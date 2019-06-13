<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\modules\Reservations\models\Reservations;
use backend\modules\Reservations\models\ReservationsAdminSearchModel;
use kartik\grid\GridView;
use kartik\helpers\Html;
use backend\components\extra;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


?>

<!--suppress ALL -->
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php

    $chartProvider=$chartDataProvider->query->all();
    $series2=array();
    $price=array();
    $sources=array();


    /**
     * Visualise Chart on Bookings data TODO: Sort, Import Refunded Bookings + Voucher Orders
     */
    foreach($chartProvider as $data){


        if(!in_array($data->source,$sources)){
            $sources[]=$data->source;

        }
        $data->data=json_decode($data->data);



        $cBookingId=$data->bookingId;
        if(isset($data->data->orderDetails)) {
            $cBookingPaidDate = date('Y-m-d', strtotime($data->data->orderDetails->paid_date));

            if(!isset($data->data->orderDetails->order_currency)) {
                $cBookingCurrency='EUR';

            }else{
                $cBookingCurrency = $data->data->orderDetails->order_currency;

            }

            if(isset($data->data->boookingDetails->booking_cost)) {
                $cBookingTotal = $data->data->boookingDetails->booking_cost;
            }
            else{
                $cBookingTotal ='0';//**Todo  update $data booking cost;

            }
            if ($cBookingCurrency != 'EUR') {
                $cBookingTotal = intval($cBookingTotal) / 300;
            }



            /**
             * A fenti if azt az esetet vizsgálja ha az order total mégse annyi mint a booking total pl kupon/teszt vásárlás
             */
            if (isset($price[$cBookingPaidDate][$data->source])) {
                if(isset($data->data->orderDetails->order_total)) {
                    if ($data->data->orderDetails->order_total == '0') {
                        $cBookingTotal = 0;
                    }
                }

                $price[$cBookingPaidDate][$data->source] += intval($cBookingTotal);
            } else {
                if(isset($data->data->orderDetails->order_total)) {
                    if ($data->data->orderDetails->order_total == '0') {
                        $cBookingTotal = 0;
                    }
                }
                $price[$cBookingPaidDate][$data->source] = intval($cBookingTotal);
            }
        }

    }


    foreach($sources as $source){
        $entity['name']=$source;
        $entity['data']=array();
        foreach ($price as $pDate=>$pValue){
            if(isset($pValue[$source])) {
                $oneDate = array(0 => date('Y-m-d',strtotime($pDate)), 1 => $pValue[$source]);
                $entity['data'][] = $oneDate;
            }

        }

        /**
         * $array[] is 3x faster than array push
         */
        $series2[]=$entity;
    }
    function sortFunction( $a, $b ) {
        return strtotime($a["0"]) - strtotime($b["0"]);
    }

    /**
     * Sorba teszem itt a dátumokat
     */
    $finalSeries=[];

    foreach ($series2 as $serie){
        #  echo '<br/><br/>Szeria sorting előtt';
        #  var_dump($serie);


        usort($serie["data"],"sortFunction");
        $finalSeries[]=$serie;
        # echo '<br/><br/>Szeria sorting után';
        # var_dump($serie);


    }

    $gridColumns = [
        'id',

       # 'bookingId',


        'source',
        'sellerName',


        'bookingCost',
        'orderCurrency',
        'bookedChairsCount',
        [
            'label' => 'Invoice date',
            'attribute' => 'invoiceDate',
            'filter' => \yii\jui\DatePicker::widget([
                'model' => $searchModel,
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
            'format'=>'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingedit?id='.$model->returnId().'">Edit'.'</a>';
            }
        ],




    ];

    echo \kartik\grid\GridView::widget([



        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'pjax'=>false,
        'toolbar' =>  [
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
        'striped'=>true,
        'panel' => [
            'heading' => '<i class="fa fa-calendar"></i>',

        ],



    ]);

    $groupedGridColumns = [
        ['class' => kartik\grid\SerialColumn::class],
        [
            'attribute' => 'invoiceMonth',
            'group' => true,
            'groupFooter' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                $im = date("m", strtotime($model->invoiceDate));
                $iy = date("Y", strtotime($model->invoiceDate));

                return [
                    'mergeColumns' => [[1, 3]],
                    'content' => [             // content to show in each summary cell
                        1 => "Month Total ({$im}→{$iy})",
                        4 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        4 => ['format' => 'number', 'decimals' => 0],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        4 => ['class' => 'text-right'],
                    ],
                    'options' => ['class' => 'success table-success h6']
                ];
            }
        ],
        [
            'attribute' => 'source',
            'width' => '310px',
            'value' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                return $model->source;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(Reservations::find()->orderBy('source')->asArray()->all(), 'source', 'source'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Any supplier'],
            'subGroupOf' => 1,
            'group' => true,
            'groupFooter' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                return [
                    'mergeColumns' => [[2, 3]],
                    'content' => [              // content to show in each summary cell
                        2 => "Source Total ({$model->source}})",
                        4 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        4 => ['format' => 'number', 'decimals' => 0],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        4 => ['class' => 'text-right'],
                    ],
                    'options' => ['class' => 'success table-success h6']
                ];
            }
        ],
        [
            'attribute' => 'sellerName',
            'pageSummary' => 'Page Summary',
            'pageSummaryOptions' => ['class' => 'text-right'],
            'subGroupOf' => 2,
            'group' => true,
            'groupFooter' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                $im = date("m", strtotime($model->invoiceDate));
                $iy = date("Y", strtotime($model->invoiceDate));

                return [
                    'content' => [              // content to show in each summary cell
                        3 => "sELLER Total ({$model->sellerName}})",
                        4 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        4 => ['format' => 'number', 'decimals' => 0],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        4 => ['class' => 'text-right'],
                    ],
                    'options' => ['class' => 'success table-success h6']
                ];
            }
        ],
        [
            'attribute' => 'booking_cost',
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal',  0],
            'pageSummary' => true,
        ],
    ];

    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => $groupedGridColumns,
    ]);

    if(Yii::$app->user->getIdentity()->username !== "manager") {
        echo \onmotion\apexcharts\ApexchartsWidget::widget([
            'type' => 'bar',
            'height' => '450',
            'chartOptions' => [
                'chart' => [
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom'
                    ],
                ],

                'xaxis' => [
                    'type' => 'datetime',
                ],
                'dataLabels' => [
                    'enabled' => false,
                ],
                'stroke' => [
                    'show' => true,

                    'curve'=> 'smooth',
                ],
                'legend' => [
                    'verticalAlign' => 'top',
                    'horizontalAlign' => 'left',
                ],
            ],
            'series' => $finalSeries
        ]);
    }


    ?>





    <script>


    </script>

</div>