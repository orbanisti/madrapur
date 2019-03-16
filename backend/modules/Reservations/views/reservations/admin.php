<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Foglalások');
$this->params['breadcrumbs'][] = $this->title;
?>

<!--suppress ALL -->
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'bookingId',
        'productId',
        'source',
        'invoiceDate',
        'bookingDate',
        [
            'label' => 'Edit Booking',
            'format'=>'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingedit?bookingId='.$model->returnBookingId().'">Edit'.'</a>';
            }
        ],

    ];

    echo \yii\grid\GridView::widget([
        'pager' => [
            'firstPageLabel' => Yii::t('app', 'Első oldal'),
            'lastPageLabel' => Yii::t('app', 'Utolsó oldal'),
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]);


    ?>
    <?php

   var_dump($dataProvider);
    ?>

    <div id="jsonPre">
        <?php
        $series = [
            [
                'name' => 'Entity 1',
                'data' => [
                    ['2018-10-04', 4.66],
                    ['2018-10-05', 5.0],
                ],
            ],
            [
                'name' => 'Entity 2',
                'data' => [
                    ['2018-10-04', 3.88],
                    ['2018-10-05', 3.77],
                ],
            ],
            [
                'name' => 'Entity 3',
                'data' => [
                    ['2018-10-04', 4.40],
                    ['2018-10-05', 5.0],
                ],
            ],
            [
                'name' => 'Entity 4',
                'data' => [
                    ['2018-10-04', 4.5],
                    ['2018-10-05', 4.18],
                ],
            ],
        ];

        echo \onmotion\apexcharts\ApexchartsWidget::widget([
            'type' => 'bar', // default area
            'height' => '400', // default 350
            'width' => '500', // default 100%
            'chartOptions' => [
                'chart' => [
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom'
                    ],
                ],
                'xaxis' => [
                    'type' => 'datetime',
                    // 'categories' => $categories,
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => false,
                        'endingShape' => 'rounded'
                    ],
                ],
                'dataLabels' => [
                    'enabled' => false
                ],
                'stroke' => [
                    'show' => true,
                    'colors' => ['transparent']
                ],
                'legend' => [
                    'verticalAlign' => 'bottom',
                    'horizontalAlign' => 'left',
                ],
            ],
            'series' => $series
        ]);
        ?>

    </div>

    <?php


    $form = ActiveForm::begin([
        'id' => 'date-import',
        'action' => 'admin',
        'options' => ['class' => 'modImp'],
    ]) ?>

    <style>
        .dateImportWidget {
            background-color: #eee;
            padding: 10px;
        }

        .dateImportWidget input {
            width: 20%;

        }


    </style>

    <div class="box">
        <div class="box-title"><h2>Importálás</h2></div>

        <?php


        # foreach ($response as $booking){
        if (isset($importResponse)) {
            // echo 'Import Státusza: ' . $importResponse . '<br/>';
            if (YII_ENV_DEV) {
                echo($importResponse);
            }
        }


        #}


        ?>


        <div class="dateImportWidget">
            <?php


            ?>
            <?= $form->field($dateImportModel, 'dateFrom')->widget(\yii\jui\DatePicker::class, [         //'language' => 'ru',
                //'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
            <?= $form->field($dateImportModel, 'dateTo')->widget(\yii\jui\DatePicker::class, [         //'language' => 'ru',
                //'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
            <?= $form->field($dateImportModel, 'source')->dropDownList(array('https://budapestrivercruise.eu' => 'https://budapestrivercruise.eu', 'https://silver-line.hu' => 'https://silver-line.hu'), array('options' => array('https://budapestrivercruise.eu' => array('selected' => true)))); ?>





            <?php ActiveForm::end() ?>
        </div>
        <div class="dateImportStatus">
            <strong>Log</strong>
            <span id="currLog">

            </span>
        </div>


    </div>


    <script>


    </script>

</div>