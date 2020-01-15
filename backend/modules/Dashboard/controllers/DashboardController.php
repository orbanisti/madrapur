<?php

namespace backend\modules\Dashboard\controllers;

use backend\controllers\Controller;
use backend\modules\Modevent\models\Modevent;
use backend\modules\Product\models\Product;
use backend\modules\Reservations\models\Reservations;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use common\models\User;
use kartik\dynagrid\DynaGrid;
use kartik\icons\Icon;
use Yii;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;

/**
 * Controller for the `Dashboard` module
 */
class DashboardController extends Controller {
    /**
     * Renders the admin view for the module
     *
     * @return string
     *
     */

    public function actionProfile(){

        if($userId=Yii::$app->request->get('id')){
            $user=User::findOne($userId);
            $gridColumns = [
                [
                    'label' => 'Ticket Id',
                    'attribute' => 'ticketId',

                ],

                [
                    'label' => 'Product',
                    'attribute' => 'productId',
                    'format' => 'html',
                    'value' => function ($model) {
                        return (Product::getProdById($model->productId))->title;
                    },

                    'pageSummaryOptions' => ['colspan' => 2],
                ],

                [
                    'label' => 'Persons',
                    'attribute' => 'bookedChairsCount',
                    'format' => 'html',
                    'value' => function ($model) {
                        $sellerBadge = '';
                        if (isset($model->iSellerName)) {

                            $sellerBadge = " <span class=\" badge bg-yellow\">" . $model->iSellerName . "</span>";
                        }

                        return $model->bookedChairsCount . ' ' . Icon::show(
                                'users', [
                                           'class' => 'fa-lg', 'framework'
                                           => Icon::FA
                                       ]
                            ) . $sellerBadge;
                    }
                ],
                [
                    'label' => 'Cost',
                    'attribute' => 'booking_cost',

                    'format' => 'html',
                    'value' => function ($model) {

                        if ($model->order_currency == 'EUR') {
                            $currencySymbol = '<i class="fas fa-euro-sign  "></i>';
                        } else {
                            $currencySymbol = 'Ft';
                        }
                        if ($model->status == 'unpaid') {
                            $currencySymbol .= '<span class="badge badge-pill badge-warning">unpaid</span>';
                        }
                        return $model->booking_cost . ' ' . $currencySymbol;
                    },


                    'pageSummaryOptions' => ['colspan' => 2],

                ],
                [
                    'label' => 'Partner',
                    'attribute' => 'sellerName',
                    'format' => 'html',
                    'value' => function ($model) {
                        if ($model->sellerName === Yii::$app->user->getIdentity()->username) {
                            return '';
                        }

                        return $model->sellerName;
                    }

                ],
                [
                    'label' => 'Paid Method',
                    'attribute' => 'paidMethod',
                    'format' => 'html',
                    'value' => function ($model) {
                        return $model->paidMethod;
                    }
                ],
                [
                    'label' => 'Notes',
                    'attribute' => 'notes',
                    'format' => 'html',
                    'value' => function ($model) {
                        return $model->notes;
                    }
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url) {
                            return Html::a(
                                '<i class="fas fa-eye fa-lg "></i>',
                                $url,
                                [
                                    'title' => Yii::t('backend', 'View')
                                ]
                            );
                        },

                    ],

                ],

            ];

            $query=Reservations::find()->andFilterWhere(['=','sellerId',$user->id]);
            $userDataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'pagination' => [
                                                           'pageSize' => 5,
                                                       ],
                                                   ]);


            $userGrid=Dynagrid::widget(
                [
                    'columns' => $gridColumns,
                    'theme'=>'panel-info',
                    'showPersonalize'=>false,
                    'gridOptions'=>[
                        'dataProvider'=>$userDataProvider,
                        'filterModel'=>new \backend\modules\Reservations\models\Reservations(),
                        'showPageSummary'=>true,
                        'floatHeader'=>false,
                        'pjax'=>false,
                        'responsiveWrap'=>false,
                        'panel'=>[

                            'after' => false
                        ],
                        'toolbar' =>  [

                            ['content'=>'{dynagrid}'],
                            '{export}',
                            '{toggleData}',
                        ]
                    ],
                    'options'=>['id'=>'dynagrid-1']
                ]);

            return $this->render('profile',['user'=>$user,'userGrid'=>$userGrid]);

        }

        return $this->redirect('admin');

    }
    public function actionStreet(){


        return $this->render('street');

    }

    public function actionManager(){
        $searchmodel = new TicketBlockSearchModel();

        $myTicketBlocks=$searchmodel->find()->andFilterWhere([
                                                                 '=',
                                                                 'assignedTo',
                                                                 Yii::$app->user->id
                                                             ])->all();
        $allTicketBlocks=[];
//        if(Yii::$app->user->can('streetAdmin')){
            $allTicketBlocks=$searchmodel->find()->all();
//        }

        $allTicketHolders=[];
        foreach ($allTicketBlocks as $ticketBlock){
            if(!in_array($ticketBlock->assignedTo,$allTicketHolders)){
                $allTicketHolders[]=$ticketBlock->assignedTo;
            }
        }




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
                    'info',
                    'Ticket block set successfully!<br>Have a bright day!'
                );

                $this->redirect('admin');
            }
        }



        return $this->render('manager',[
            'allTicketBlocks'=>$allTicketBlocks,
            'myTicketBlocks'=>$myTicketBlocks,
            'allTicketHolders'=>$allTicketHolders,

        ]);
    }






    public function actionAdmin() {
        $viewType = '';
        $viewName = 'admin';

        if (Yii::$app->user->can("hotline")) {
            $viewType = 'hotline/';
            $viewName = 'admin';
            sessionSetFlashAlert('warning', "Screen under construction");
        }

        if (Yii::$app->user->can("streetSeller")) {
            $viewType = '';
            $viewName = 'street';

            if ($cb = Yii::$app->request->get('change-ticket-block')) {
                $block = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if ($block && $block->returnStartId() !== $cb) {
                    $block->isActive = false;
                    $block->save(false);
                }

                $block = null;
            }

            if ($id = Yii::$app->request->get('id')) {
                $ticketBlockSearchModel = TicketBlockSearchModel::findOne(['=', 'id', $id]);
                $alreadyActive = false;

                if ($ticketBlockSearchModel && $ticketBlockSearchModel->isActive) {
                    $alreadyActive = true;
                } else {
                    $ticketBlockSearchModel->isActive = true;

                    if ($ticketBlockSearchModel->save(false)) {
                        sessionSetFlashAlert(
                            'success',
                            'Ticket block set successfully!<br>Have a bright day!'
                        );


                    }
                }
            }

            if ((!$id) || (isset($alreadyActive) && $alreadyActive)) {
                $assignedBlock = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if (!$assignedBlock) {
                    $ownBlocks = TicketBlockSearchModel::find()->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])->all();

                    if (0 === count($ownBlocks)) {
                        sessionSetFlashAlert(
                            'warning',
                            'No ticket block found. :(<br>Have a bright day!'
                        );
                    } else if (1 < count($ownBlocks)) {
                        $viewName = 'selectTicket';

                        $selectTicket = new \stdClass();
                        $selectTicket->searchModel = new TicketBlockSearchModel();
                        $selectTicket->dataProvider = $selectTicket->searchModel->search([]);
                        $selectTicket->gridColumns = [
                            'startId',
                            [
                                'label' => 'Current Ticket ID',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return $model->returnCurrentId();
                                }
                            ],
                            [
                                'label' => 'Activate block',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return '<a href="/Dashboard/dashboard/admin?id=' . $model->returnId() . '">Activate block' . '</a>';
                                }
                            ],
                        ];
                    } else {
                        $ticketBlockSearchModel = $ownBlocks[0];
                        $ticketBlockSearchModel->isActive = true;

                        if ($ticketBlockSearchModel->save(false)) {
                            sessionSetFlashAlert(
                                'success',
                                'Active ticket block set automatically.<br>Have a bright day!'
                            );
                        }

                        $assignedBlock = $ticketBlockSearchModel;
                    }
                }

                if ($assignedBlock && $skipTicket = Yii::$app->request->get('skip-ticket') === $assignedBlock->returnCurrentId()) {
                    sessionSetFlashAlert('warning', 'Ticket skipped.');

                    $assignedBlock->skipCurrentTicket();
                    return $this->redirect('admin');
                }
            }
        }
        if (Yii::$app->user->can("streetAdmin")) {
            $viewType = '';
            $viewName = 'streetAdmin';

            if ($cb = Yii::$app->request->get('change-ticket-block')) {
                $block = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if ($block && $block->returnStartId() !== $cb) {
                    $block->isActive = false;
                    $block->save(false);
                }

                $block = null;
            }

            if ($id = Yii::$app->request->get('id')) {
                $ticketBlockSearchModel = TicketBlockSearchModel::findOne(['=', 'id', $id]);
                $alreadyActive = false;

                if ($ticketBlockSearchModel && $ticketBlockSearchModel->isActive) {
                    $alreadyActive = true;
                } else {
                    $ticketBlockSearchModel->isActive = true;

                    if ($ticketBlockSearchModel->save(false)) {
                        sessionSetFlashAlert(
                            'success',
                            'Ticket block set successfully!<br>Have a bright day!'
                        );


                    }
                }
            }

            if ((!$id) || (isset($alreadyActive) && $alreadyActive)) {
                $assignedBlock = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if (!$assignedBlock) {
                    $ownBlocks = TicketBlockSearchModel::find()->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])->all();

                    if (0 === count($ownBlocks)) {
                        sessionSetFlashAlert(
                            'warning',
                            'No ticket block found. :(<br>Have a bright day!'
                        );
                    } else if (1 < count($ownBlocks)) {
                        $viewName = 'manager';

                        $selectTicket = new \stdClass();
                        $selectTicket->searchModel = new TicketBlockSearchModel();
                        $selectTicket->dataProvider = $selectTicket->searchModel->search([]);
                        $selectTicket->gridColumns = [
                            'startId',
                            [
                                'label' => 'Current Ticket ID',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return $model->returnCurrentId();
                                }
                            ],
                            [
                                'label' => 'Activate block',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return '<a href="/Dashboard/dashboard/admin?id=' . $model->returnId() . '">Activate block' . '</a>';
                                }
                            ],
                        ];
                    } else {
                        $ticketBlockSearchModel = $ownBlocks[0];
                        $ticketBlockSearchModel->isActive = true;

                        if ($ticketBlockSearchModel->save(false)) {
                            sessionSetFlashAlert(
                                'success',
                                'Active ticket block set automatically.<br>Have a bright day!'
                            );
                        }

                        $assignedBlock = $ticketBlockSearchModel;
                    }
                }

                if ($assignedBlock && $skipTicket = Yii::$app->request->get('skip-ticket') === $assignedBlock->returnCurrentId()) {
                    sessionSetFlashAlert('warning', 'Ticket skipped.');

                    $assignedBlock->skipCurrentTicket();
                    return $this->redirect('admin');
                }
            }
        }

        $reservationmodel=new Reservations();
        $user=Yii::$app->user;
        $today= $today = date('Y-m-d');

        $userDataProvider = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today);



        $userDataHuf = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today, 'HUF');
        $userDataEur = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today, 'EUR');
        $hufToday = Reservations::sumDataProvider($userDataHuf->models, 'booking_cost');
        $hufCashToday = Reservations::sumDataProviderCash($userDataHuf->models, 'booking_cost');
        $hufCardToday = Reservations::sumDataProviderCard($userDataHuf->models, 'booking_cost');
        $eurCashToday = Reservations::sumDataProviderCash($userDataEur->models, 'booking_cost');
        $eurCardToday = Reservations::sumDataProviderCard($userDataEur->models, 'booking_cost');


        return $this->render(
            $viewType . $viewName, [
                'ownBlocks' => isset($ownBlocks) ? $ownBlocks : [],
                'startTicketId' => isset($assignedBlock) ? $assignedBlock->returnStartId() : 'N/A',
                'nextTicketId' => isset($assignedBlock) ? $assignedBlock->returnCurrentId() : 'N/A',
                'selectTicket' => isset($selectTicket) ? $selectTicket : null,
                'hufCardToday'=>$hufCardToday,
                'eurCashToday'=>$eurCashToday,
                'hufCashToday'=>$hufCashToday,
                'eurCardToday'=>$eurCardToday,



            ]
        );
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
