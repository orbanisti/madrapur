<?php

use backend\modules\Reservations\models\Reservations;
use backend\modules\Reservations\models\ReservationsAdminSearchModel;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#overview" data-toggle="tab"><?= Yii::t('app','Overview') ?></a></li>
    <li><a href="#overview-monthly" data-toggle="tab"><?= Yii::t('app','Overview (monthly)') ?></a></li>
    <li><a href="#street" data-toggle="tab"><?= Yii::t('app','Street') ?></a></li>
    <li><a href="#hotel" data-toggle="tab"><?= Yii::t('app','Hotel') ?></a></li>
</ul>

<?php
$form = ActiveForm::begin([
    'id' => 'SZUKITES',
    'action' => 'admin',
]);

$dummyProduct = new \backend\modules\Product\models\Product();
$dummyProduct->start_date = $startDate . ' to ' . $endDate;

echo $form->field($dummyProduct, 'start_date')->widget(DateRangePicker::class, [
    'name' => 'date_range',
    'value' => $startDate . ' to ' . $endDate,
    'presetDropdown' => true,
    'hideInput' => true,
    'convertFormat' => false,
])->label("Date Range");

echo \kartik\helpers\Html::submitButton(Yii::t('backend', 'Szűrés'),
    [
        'class' => 'btn btn-primary btn-flat btn-block',
        'name' => 'filter-button'
    ]);

ActiveForm::end();
?>

<div class="tab-content">
    <div class="tab-pane active" id="overview">
        <div class="panel panel-default">
            <div class="panel-heading">
                OVERVIEW
            </div>
            <div class="panel-body">
                <div class="container-items">
                    <?php
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
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="overview-monthly">
        <div class="panel panel-default">
            <div class="panel-heading">
                OVERVIEW (monthly)
            </div>
            <div class="panel-body">
                <div class="container-items">
                    <script>
                        function formatter(source, data) {
                            var p = 0;

                            source.forEach(function (s) { p += s; });

                            return p + " EUR";
                        }
                    </script>

                    <?php
                        $groupedGridColumns = [
                            ['class' => kartik\grid\SerialColumn::class],
                            [
                                'attribute' => 'invoiceMonth',
                                'value' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                                    return date("F", strtotime($model->invoiceDate));
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(Reservations::find()->orderBy('invoiceMonth')->asArray()->all(), 'invoiceMonth', 'invoiceMonth'),
                                'filterInputOptions' => ['placeholder' => 'Any month'],
                                'group' => true,
                                'groupFooter' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                                    return [
                                        'mergeColumns' => [[1, 4]],
                                        'content' => [             // content to show in each summary cell
                                            1 => "Month Total ($model->invoiceMonth)",
                                            5 => GridView::F_SUM,
                                        ],
                                        'contentFormats' => [      // content reformatting for each summary cell
                                            5 => ['format' => 'callback', 'func' => 'formatter'],
                                        ],
                                        'contentOptions' => [      // content html attributes for each summary cell
                                            5 => ['class' => 'text-right'],
                                        ],
                                        'options' => ['class' => 'active table-active h6']
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
                                'filter' => ArrayHelper::map(Reservations::find()->orderBy('invoiceMonth')->asArray()->all(), 'source', 'source'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Any source'],
                                'subGroupOf' => 1,
                                'group' => true,
                                'groupFooter' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                                    return [
                                        'mergeColumns' => [[2, 4]],
                                        'content' => [              // content to show in each summary cell
                                            2 => "Source Total ({$model->source}})",
                                            5 => GridView::F_SUM,
                                        ],
                                        'contentFormats' => [      // content reformatting for each summary cell
                                            5 => ['format' => 'callback', 'func' => 'formatter'],
                                        ],
                                        'contentOptions' => [      // content html attributes for each summary cell
                                            5 => ['class' => 'text-right'],
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
                                        'mergeColumns' => [[3, 4]],
                                        'content' => [              // content to show in each summary cell
                                            3 => "Seller Total ({$model->sellerName})",
                                            5 => GridView::F_SUM,
                                        ],
                                        'contentFormats' => [      // content reformatting for each summary cell
                                            5 => ['format' => 'callback', 'func' => 'formatter'],
                                        ],
                                        'contentOptions' => [      // content html attributes for each summary cell
                                            5 => ['class' => 'text-right'],
                                        ],
                                        'options' => ['class' => 'danger table-danger h6']
                                    ];
                                }
                            ],
                            [
                                'attribute' => 'bookingId',
                                'pageSummary' => 'Page Summary',
                                'pageSummaryOptions' => ['class' => 'text-right'],
                                'subGroupOf' => 3,
                            ],
                            [
                                'attribute' => 'booking_cost',
                                'value' => function (ReservationsAdminSearchModel $model, $key, $index, $widget) {
                                    return "{$model->booking_cost} {$model->order_currency}";
                                },
                                'width' => '150px',
                                'hAlign' => 'right',
                                'pageSummary' => true,
                            ],
                        ];

                        echo GridView::widget([
                            'dataProvider' => $groupedDataProvider,
                            'filterModel' => $searchModel,
                            'showPageSummary' => true,
                            'pjax' => true,
                            'striped' => true,
                            'hover' => true,
                            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                            'columns' => $groupedGridColumns,
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="street">
        <div class="panel panel-default">
            <div class="panel-heading">
                STREET
            </div>
            <div class="panel-body">
                <div class="container-items">
                    <?php
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
                            'series' => $finalStreetSeries
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="hotel">
        <div class="panel panel-default">
            <div class="panel-heading">
                HOTEL
            </div>
            <div class="panel-body">
                <div class="container-items">
                    <?php
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
                            'series' => $finalHotelSeries
                        ]);
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>



