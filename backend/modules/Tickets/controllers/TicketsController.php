<?php

namespace backend\modules\Tickets\controllers;

use backend\controllers\Controller;
use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\Reservations\models\Reservations;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketSearchModel;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use common\models\User;
use common\models\UserProfile;
use kartik\grid\EditableColumn;
use kartik\helpers\Html;
use Project\Command\YourCustomCommand;
use Yii;
use yii\db\conditions\InCondition;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

/**
 * Controller for the `Tickets` module
 */
class TicketsController extends Controller {

    public $enableCsrfValidation = false;

    public static $bans = [
        "admin" => [
            "streetSeller",
            "streetAdmin"
        ],
    ];

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
                    return '<a href="/Tickets/tickets/view-block?ticketBlockStartId=' . $model->returnStartId() . '">Edit' . '</a>';
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
                $prefix = "";

                while (!is_numeric($startId)) {
                    $prefix .= mb_substr($startId, 0, 1);
                    $startId = mb_substr($startId, 1, mb_strlen($startId) - 1);
                }

                $currentId = (int)$startId;
                $length = mb_strlen($startId);
                $values = '(\'' . $prefix . sprintf('%0' . mb_strlen($startId) . 'd', $currentId) . '\')';
                $idToCheck = $currentId - 50;

                do {
                    $idToCheck++;
                    $allowed = !table_exists('modulus_tb_' . $prefix . sprintf('%0' . $length . 'd', $idToCheck));
                } while (($idToCheck !== ((int)$startId + 49)) && $allowed);

                if (!$allowed) {
                    sessionSetFlashAlert(
                        'error',
                        'Specified start ID would conflict with block ' . $prefix . sprintf('%0' . $length . 'd', $idToCheck) . '.'
                    );
                } else {
                    do {
                        $values .= ',(\'' . $prefix . sprintf('%0' . $length . 'd', ++$currentId) . '\')';
                    } while ($currentId < ((int)$startId + 49));

                    $sql = "CALL createTicketBlockTable(:tableName, :startId, :values)";
                    $params = [
                        ':tableName' => Yii::$app->request->post('startId'),
                        ':startId' => Yii::$app->request->post('startId'),
                        ':values' => $values
                    ];
                    Yii::$app->db->createCommand($sql, $params)->execute();

                    $ticketBlock = new TicketBlock();
                    $ticketBlock->startId = $prefix . $startId;
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
                if($assignment->user_id === $user->id) {
                    if (!Yii::$app->user->can($assignment->item_name))
                        unset($users[$idx]);
                }

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
        $model = TicketSearchModel::useTable("modulus_tb_" . $blockId);

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
    public function actionViewBlock($ticketBlockStartId) {
        $searchModel = TicketSearchModel::useTable("modulus_tb_$ticketBlockStartId");
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumns = [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return \kartik\grid\GridView::ROW_COLLAPSED;
                },
                'enableCache' => false,
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
                'detail' => function (TicketSearchModel $model, $key, $index, $column) {
                    if (!is_numeric($model->reservationId)) {
                        return '<div class="alert">No data found.</div>';
                    }

                    $searchModel = Reservations::findOne(['ticketId' => $key]);
                    $dataProvider = $searchModel->search(['ticketId' => $key]);

                    $gridColumns = [
                        [
                            'class' => EditableColumn::class,
                            'attribute' => 'firstName',

                            'label' => 'First Name',
                            'refreshGrid' => false,

                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'formOptions' => [
                                        'id' => 'gv1_' . $model->id . '_form_first_name',
                                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                    ],
                                    'options' => [
                                        'id' => 'gv1_' . $model->id . '_first_name',
                                    ],
                                ];
                            },
                        ],
                        [
                            'class' => EditableColumn::class,
                            'attribute' => 'lastName',
                            'label' => 'Last Name',
                            'refreshGrid' => false,
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'formOptions' => [
                                        'id' => 'gv1_' . $model->id . '_form_last_name',
                                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                    ],
                                    'options' => [
                                        'id' => 'gv1_' . $model->id . '_last_name',
                                    ],
                                ];
                            },

                        ],
                    ];

                    if ($dataProvider->count) {
                        return $this->renderPartial(
                            'partial/editDetails',
                            [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'gridColumns' => $gridColumns
                            ]
                        );
                    } else {
                        return '<div class="alert alert-danger">No data found. Contact an Administrator.</div>';
                    }
                },
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
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionViewAssignedBlocks() {
        $searchModel = new TicketBlockSearchModel();
        $dataProvider = $searchModel->search(
            array_merge(
                Yii::$app->request->queryParams,
                [
                    'assignedTo' => Yii::$app->user->identity->username,
                ]
            )
        );
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
                    return '<a href="/Tickets/tickets/view-block?ticketBlockStartId=' . $model->returnStartId() . '">Edit' . '</a>';
                }
            ],
            [
                'label' => 'Activate',
                'format' => 'html',
                'value' => function (TicketBlockSearchModel $model) {
                    return $model->isActive ?: '<a href="/Tickets/tickets/view-assigned-blocks?changeTo=' . $model->returnStartId() . '">Activate' . '</a>';
                }
            ],
        ];

        if ($changeTo = Yii::$app->request->get('changeTo')) {
            $block = TicketBlockSearchModel::find()
                ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                ->andWhere('isActive IS TRUE')
                ->one();

            if ($block && $block->returnStartId() !== $changeTo) {
                $block->isActive = false;
                $block->save(false);
            }

            $block = TicketBlockSearchModel::find()
                ->andFilterWhere(['=', 'startId', $changeTo])
                ->one();

            $block->isActive = true;
            if ($block->save(false)) {
                sessionSetFlashAlert(
                    'success',
                    'Ticket block set successfully!<br>Have a bright day!'
                );
            }
        }

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
