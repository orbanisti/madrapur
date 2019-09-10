<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
    use backend\modules\Reservations\models\Reservations;
    use kartik\helpers\Html;
    use kartik\icons\Icon;

?>


<?php

    $gridColumns = [
        'id',

        # 'bookingId',

        [
            'label' => 'Seller',
            'attribute'=>'sellerName'
        ],
        [
            'label' => 'Cost',
            'attribute'=>'bookingCost'
        ],
        [
            'label' => 'Currency',
            'attribute'=>'orderCurrency'
        ],
        [
            'label' => 'Persons',
            'attribute'=>'bookedChairsCount'
        ],
        [
            'label' => 'Invoice date',
            'attribute' => 'invoiceDate',
            'filter' => \yii\jui\DatePicker::widget([
                'model' => new Reservations(),
                'attribute' => 'invoiceDate',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => [
                    'autoClose' => true
                ]
            ]),
            'format' => 'raw',
        ],
        #g 'updateDate',

        # 'bookingDate',
        [
            'label' => 'Edit Booking',
            'format' => 'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingview?id=' . $model->returnId() . '">View' . '</a>';
            }
        ],

    ];
    $gridColumns2 = [
        'updateDate',
        'invoiceDate',

        [
            'label' => 'Persons',
            'attribute'=>'bookedChairsCount',
            'format'=>'html',
            'value'=>function($model){
            return $model->bookedChairsCount.Icon::show('users', ['class'=>'fa-lg','framework'
                =>Icon::FA]);
            }
        ],
    [
        'label' => 'Cost',
        'attribute'=>'bookingCost',
         'format'=>'html',
            'value'=>function($model){

            if($model->orderCurrency=='EUR'){
                $currencySymbol=Icon::show('euro', ['class'=>'fa-lg','framework'
                =>Icon::FA]);
            }else{
                $currencySymbol='Ft';
            }

            return $model->bookingCost.' '.$currencySymbol;
            }
    ],


    ];
    $grid=\kartik\grid\GridView::widget([

                'dataProvider' => $dataProvider,

                'columns' => $gridColumns,
                'pjax' => false,
                'toolbar' => [
                    [

                        'options' => ['class' => 'btn-group mr-2']
                    ],
                    '{export}',
                    '{toggleData}',
                ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                // set export properties
                'export' => [
                    'fontAwesome' => true,

                ],
                'bordered' => true,
                'striped' => true,
                'panel' => [
                    'heading' => '<i class="fa fa-calendar"></i>',

                ],

            ]);

    $gridAlltransactions=\kartik\grid\GridView::widget([

        'dataProvider' => $dataProvider,
        'columns' => $gridColumns2,
        'pjax' => false,
        'layout' => '{items}',
        'toolbar' => [
            [

                'options' => ['class' => 'btn-group mr-2']
            ],
            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true,

        ],


    ]);


            ?>

<!--suppress ALL -->
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <div class="row">

        <div class="col-lg-12">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua">
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">Transaction Center</h3>
                    <h5 class="widget-user-desc">Daily Income</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed" href="#">
                                ALL income today <span class="pull-right badge bg-green">12</span></a></li>
                        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body">
                                <?=$gridAlltransactions?>
                            </div>
                        </div>
                        <li><a href="#">EUR income today <span class="pull-right badge bg-blue">31</span></a></li>
                        <li><a href="#">HUF income today <span class="pull-right badge bg-aqua">5</span></a></li>



                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-8 col-sm-12 hidden"><?=$grid?></div>




    </div>




    <script>


    </script>

</div>