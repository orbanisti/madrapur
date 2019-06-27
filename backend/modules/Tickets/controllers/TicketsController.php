<?php

namespace backend\modules\Tickets\controllers;

use backend\models\search\UserSearch;
use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use backend\modules\Tickets\models\TicketSearchModel;
use common\models\User;
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
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Tickets/tickets/viewTicket?id='.$model->returnStartId().'">'
                        .$model->returnStartId().'</a>';
                },
                'filter' => function() {

                }
            ],
            [
                'label' => 'Current ID',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Tickets/tickets/viewTicket?id='.$model->returnCurrentId().'">'
                        .$model->returnCurrentId().'</a>';
                },
                'filter' => function() {

                }
            ],
            [
                'label' => 'View Ticket Block',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Tickets/tickets/viewBlock?id='.$model->returnId().'">Edit'.'</a>';
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

//            Yii::error(Yii::$app->request->post());
//            Yii::error((int)Yii::$app->request->post('startId'));
//            Yii::error(sprintf('%07d', (int)Yii::$app->request->post('startId')));
            $saved = false;

            if (Yii::$app->request->post('startId')) {
                $startId = Yii::$app->request->post('startId');
                $currentId = (int)$startId;
                $values = '(\'V' . sprintf('%07d', $currentId) . '\')';

                do {
                    $values .= ',(\'V' . sprintf('%07d', ++$currentId) . '\')';
                } while ($currentId < ((int)$startId + 49));

                $sql = "CALL createTicketBlockTable(:tableName, :startId, :values)";
                $params = [
                    ':tableName' => Yii::$app->request->post('startId'),
                    ':startId' => Yii::$app->request->post('startId'),
                    ':values' => $values
                ];
                Yii::$app->db->createCommand($sql, $params)->execute();

                $ticketBlock = new TicketBlock();
                $ticketBlock->startId = 'V' . $startId;
                $ticketBlock->assignedTo = (int)Yii::$app->request->post('TicketBlock')['assignedTo'];
                $ticketBlock->assignedBy = (int)Yii::$app->user->id;
                $saved = $ticketBlock->save(false);

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


                if (!Yii::$app->user->can("assign_" . $assignments->item_name))

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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
