<?php

namespace backend\modules\Tickets\controllers;

use backend\models\search\UserSearch;
use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketBlockDummySearchModel;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use backend\modules\Tickets\models\TicketSearchModel;
use common\models\User;
use kartik\helpers\Html;
use Yii;
use backend\controllers\Controller;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Controller for the `Tickets` module
 */
class TicketsController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $searchModel = new TicketBlockSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $gridColumns = [
            [
                'label' => 'Start ID',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-ticket?id='.$model->returnStartId().'&blockId='.$model->returnStartId().'">'
                        .$model->returnStartId().'</a>';
                },
                'filter' => Html::textInput("startId", Yii::$app->request->getQueryParam('startId', null)),
            ],
            [
                'label' => 'Current ID',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-ticket?id='.$model->returnStartId().'&blockId='.$model->returnCurrentId().'">'
                        .$model->returnCurrentId().'</a>';
                },
//                'filter' => Html::textInput("currentId"),
            ],
            [
                'label' => 'assignedTo',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    $user = User::findIdentity($model->assignedTo)->username;
                    return '<a href="/user/view?id='.$model->assignedTo.'">'.$user.'</a>';
                },
                'filter' => Html::textInput("assignedTo", Yii::$app->request->getQueryParam('assignedTo', null)),
            ],
            [
                'label' => 'View Ticket Block',
                'format'=>'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-block?id='.$model->returnId().'">Edit'.'</a>';
                }
            ],
        ];

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => $gridColumns,
        ]);
    }

    /**
     * Renders the add-block view for the module
     *
     * @return string
     * @throws ForbiddenHttpException
     * @throws \yii\db\Exception
     */
    public function actionAddBlock() {
        if (!Yii::$app->user->can('addTicketBlock'))
            throw new ForbiddenHttpException('userCan');

            Yii::error(Yii::$app->request->post());
            Yii::error((int) Yii::$app->user->id);
//            Yii::error((int)Yii::$app->request->post('startId'));
//            Yii::error(sprintf('%08d', (int)Yii::$app->request->post('startId')));
        $saved = false;

        if (Yii::$app->request->post('startId') && Yii::$app->request->post('TicketBlock')) {
            $startId = Yii::$app->request->post('startId');
            $currentId = (int)$startId;
            $values = '(\'' . sprintf('%08d', $currentId) . '\')';
            $notAllowed = false;
            $idToCheck = $currentId - 50;

            do {
                $idToCheck++;

                if ($idToCheck - 49 < 0) {
                    continue;
                }


            } while ($idToCheck !== (int)$startId);

            do {
                $values .= ',(\'' . sprintf('%08d', ++$currentId) . '\')';
            } while ($currentId < ((int)$startId + 49));

            if (Yii::$app->db->getTableSchema(Yii::$app->db->tablePrefix . 'modulus_tb_' . $startId, true) === null
                || $notAllowed) {

                $sql = "CALL createTicketBlockTable(:tableName, :startId, :values)";
                $params = [
                    ':tableName' => Yii::$app->request->post('startId'),
                    ':startId' => Yii::$app->request->post('startId'),
                    ':values' => $values
                ];
                Yii::$app->db->createCommand($sql, $params)->execute();

                $ticketBlock = new TicketBlock();
                $ticketBlock->startId = $startId;
                $ticketBlock->assignedTo = (int)Yii::$app->request->post('TicketBlock')['assignedTo'];
                $ticketBlock->assignedBy = (int)Yii::$app->user->id;
                $saved = $ticketBlock->save(false);
            } else {
                Yii::$app->session->setFlash(
                    'alert',
                    [
                        'options' => [
                            'class' => 'alert-warning'
                        ],
                        'body' => Yii::t('backend', "Ticket block ($startId) already exists!")
                    ]
                );
            }

            //return $this->render('addBlockSuccess');
        }

        $model = new TicketBlock();
        $roles = ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name');

        foreach ($roles as $i => $role) {
            if (!Yii::$app->user->can($role))
                unset($roles[$i]);
        }

        $users = User::aSelect(User::class, 'id, username', User::tableName(), '1')->all();

        /**
         * Remove this.
         */
        foreach ($users as $idx => $user) {
            //TODO remove query from foreach
            $assignments = RbacAuthAssignment::aSelect(
                RbacAuthAssignment::class,
                '*',
                RbacAuthAssignment::tableName(),
                'user_id = ' . $user->id,
                'user_id',
                'user_id'
            )->one();

            if (!Yii::$app->user->can("assign_" . $assignments["item_name"]))
                unset($users[$idx]);
        }
        /**
         * Remove end.
         */

        /**
         * Test this.
         */
//            $assignments = RbacAuthAssignment::aSelect(
//                RbacAuthAssignment::class,
//                '*',
//                RbacAuthAssignment::tableName(),
//                '1' ,
//                'user_id',
//                'user_id'
//            )->all();
//
//            foreach ($users as $idx => $user) {
//                foreach ($assignments as $idx => $assignment) {
//                    if($assignment->user_id === $user->id)
//                        if (!Yii::$app->user->can($assignment->item_name))
//                            unset($users[$idx]);
//
//                }
//            }

        $users = ArrayHelper::map($users, 'id', 'username');

        return $this->render(
        'addBlock',
            [
                'model' => $model,
                'users' => $users,
                'saved' => $saved,
            ]
        );
    }

    /**
     * Renders the viewTicket view for the module
     *
     * @param $id
     *
     * @return string
     */
    public function actionViewTicket($id, $blockId) {
        $model = TicketBlockDummySearchModel::useTable("modulus_tb_".$id);

        $model = $model::find();

        $model->andFilterWhere([
            '=',
            'ticketId',
            $blockId
        ]);

        return $this->render('viewTicket', [
            'id' => $id,
            'model' => $model->one()
        ]);
    }

    /**
     * Renders the viewBlock view for the module
     *
     * @param $id
     *
     * @return string
     */
    public function actionViewBlock($id) {

        $ticketBlockStartId = TicketBlockSearchModel::getStartId($id);

        $searchModel = TicketBlockDummySearchModel::useTable("modulus_tb_$ticketBlockStartId");
        Yii::error($searchModel::tableName());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumns = [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return \kartik\grid\GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('viewTicketInfo', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
            ],
            [
                'label' => 'ticketId',
                'format' => 'html',
                'value' => function (TicketBlockDummySearchModel  $model) use ($ticketBlockStartId) {
                    return '<a href="/Tickets/tickets/view-ticket?id='.$ticketBlockStartId.'&blockId='.$model->ticketId.'">'
                        .$model->ticketId.'</a>';
                },
                'filter' => Html::textInput("startId", Yii::$app->request->getQueryParam('startId', null)),
            ],
            'timestamp',
            'reservationId',

        ];

        return $this->render('viewBlock', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => $gridColumns,
            'id' => $id,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionViewAssignedBlocks() {
        return $this->render('viewAssignedBlocks', [

        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
