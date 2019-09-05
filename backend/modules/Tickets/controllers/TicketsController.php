<?php

namespace backend\modules\Tickets\controllers;

use backend\controllers\Controller;
use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketSearchModel;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use common\models\User;
use common\models\UserProfile;
use kartik\helpers\Html;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

/**
 * Controller for the `Tickets` module
 */
class TicketsController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * Renders the admin view for the module
     *
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
                    return '<a href="/Tickets/tickets/view-ticket?id=' . $model->returnStartId() . '&blockId=' . $model->returnStartId() . '">'
                        . $model->returnStartId() . '</a>';
                },
                'filter' => Html::textInput("startId", Yii::$app->request->getQueryParam('startId', null)),
            ],
            [
                'label' => 'Current ID',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-ticket?id=' . $model->returnStartId() . '&blockId=' . $model->returnCurrentId() . '">'
                        . $model->returnCurrentId() . '</a>';
                },
            ],
            [
                'label' => 'assignedTo',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    $user = User::findIdentity($model->assignedTo)->username;
                    return '<a href="/user/view?id=' . $model->assignedTo . '">' . $user . '</a>';
                },
                'filter' => Html::textInput("assignedTo", Yii::$app->request->getQueryParam('assignedTo', null)),
            ],
            [
                'label' => 'View Ticket Block',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-block?id=' . $model->returnId() . '">Edit' . '</a>';
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
        if (!Yii::$app->user->can('addTicketBlock')) {
            throw new ForbiddenHttpException('userCan');
        }

        if (Yii::$app->request->post('startId') && Yii::$app->request->post('TicketBlock')) {
            $startId = Yii::$app->request->post('startId');

            if (8 !== strlen($startId)) {
                sessionSetFlashAlert('error', 'Ticket ID must be 8 characters long!');
            } else {
                $currentId = (int)$startId;
                $values = '(\'' . sprintf('%08d', $currentId) . '\')';
                $idToCheck = $currentId - 50;

                do {
                    $idToCheck++;
                    $allowed = !table_exists('modulus_tb_' . sprintf('%08d', $idToCheck));
                } while (($idToCheck !== ((int)$startId + 49)) && $allowed);

                if (!$allowed) {
                    sessionSetFlashAlert(
                        'error',
                        'Specified start ID would conflict with block #' . sprintf('%08d', $idToCheck) . '.'
                    );
                } else {
                    do {
                        $values .= ',(\'' . sprintf('%08d', ++$currentId) . '\')';
                    } while ($currentId < ((int)$startId + 49));

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

                    if ($ticketBlock->save(false)) {
                        sessionSetFlashAlert(
                            'success',
                            'Ticket block created and assigned!'
                        );
                    } else {
                        sessionSetFlashAlert(
                            'error',
                            'Something went wrong...'
                        );
                    }
                }
            }
        }

        $model = new TicketBlock();
        $roles = ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name');

        foreach ($roles as $i => $role) {
            if (!Yii::$app->user->can($role)) {
                unset($roles[$i]);
            }
        }

        $users = User::aSelect(User::class, 'id, username', User::tableName(), '1')->all();

        $assignments = RbacAuthAssignment::aSelect(
            RbacAuthAssignment::class,
            '*',
            RbacAuthAssignment::tableName(),
            '1' ,
            'user_id',
            'user_id'
        )->all();

        foreach ($users as $idx => $user) {
            foreach ($assignments as $idx => $assignment) {
                if($assignment->user_id === $user->id)
                    if (!Yii::$app->user->can($assignment->item_name))
                        unset($users[$idx]);

            }
        }

        $avatars = [];

        foreach ($users as $idx => $user) {
            $avatarURL = UserProfile::findOne(['=', 'id', $user->id])->getAvatar();
            $avatars[$user->id] = $avatarURL ?: "/img/anonymous.jpg";
        }

        $users = ArrayHelper::map($users, 'id', 'username');

        return $this->render(
            'addBlock',
            [
                'model' => $model,
                'users' => $users,
                'avatars' => Json::encode($avatars)
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
        $model = TicketSearchModel::useTable("modulus_tb_" . $id);

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

        $searchModel = TicketSearchModel::useTable("modulus_tb_$ticketBlockStartId");
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
                'value' => function (TicketSearchModel $model) use ($ticketBlockStartId) {
                    return '<a href="/Tickets/tickets/view-ticket?id=' . $ticketBlockStartId . '&blockId=' . $model->ticketId . '">'
                        . $model->ticketId . '</a>';
                },
                'filter' => Html::textInput("ticketId", Yii::$app->request->getQueryParam('ticketId', null)),
            ],
            [
                'label' => 'timestamp',
                'format' => 'html',
                'value' => function (TicketSearchModel $model) use ($ticketBlockStartId) {
                    return $model->timestamp;
                },
                'filter' => Html::textInput("timestamp", Yii::$app->request->getQueryParam('timestamp', null)),
            ],
            [
                'label' => 'reservationId',
                'format' => 'html',
                'value' => function (TicketSearchModel $model) use ($ticketBlockStartId) {
                    $value = $model->reservationId;

                    if (is_numeric($model->reservationId)) {
                        $value = '<a href="/Reservations/reservations/bookingedit?id=' . $model->reservationId . '">' . $model->reservationId . '</a>';
                    }

                    return $value;
                },
                'filter' => Html::textInput("reservationId", Yii::$app->request->getQueryParam('reservationId', null)),
            ],
            [
                'label' => 'status',
                'format' => 'html',
                'value' => function (TicketSearchModel $model) {
                    return $model->status;
                },
                'filter' => Html::textInput("status", Yii::$app->request->getQueryParam('status', null)),
            ],
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
        $searchModel = new TicketBlockSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $gridColumns = [
            [
                'label' => 'Start ID',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-assigned-blocks?id=' . $model->returnStartId() . '&blockId=' . $model->returnStartId() . '">'
                        . $model->returnStartId() . '</a>';
                },
                'filter' => Html::textInput("startId", Yii::$app->request->getQueryParam('startId', null)),
            ],
            [
                'label' => 'Current ID',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-assigned-blocks?id=' . $model->returnStartId() . '&blockId=' . $model->returnCurrentId() . '">'
                        . $model->returnCurrentId() . '</a>';
                },
//                'filter' => Html::textInput("currentId"),
            ],
            [
                'label' => 'assignedTo',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    $user = User::findIdentity($model->assignedTo)->username;
                    return '<a href="/user/view?id=' . $model->assignedTo . '">' . $user . '</a>';
                },
                'filter' => Html::textInput("assignedTo", Yii::$app->request->getQueryParam('assignedTo', null)),
            ],
            [
                'label' => 'View Ticket Block',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return '<a href="/Tickets/tickets/view-assigned-blocks?id=' . $model->returnId() . '">Edit' . '</a>';
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
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
