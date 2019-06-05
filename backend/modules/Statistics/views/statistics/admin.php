<?php

use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;

?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#overview" data-toggle="tab"><?= Yii::t('app','Overview') ?></a></li>
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



