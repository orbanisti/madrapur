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
                return '<a href="/Reservations/reservations/booking>">'.$model->pista().'</a>';
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

    <div id="jsonPre">


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



            <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>

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