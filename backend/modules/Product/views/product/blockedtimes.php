<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
use backend\models\Product\Product;
    use kartik\datetime\DateTimePicker;
    use kartik\helpers\Html;
use yii\widgets\ActiveForm;

$title = 'Block Booking Times of ' . '<u>' . $currentProduct->title . '</u>';/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/

?>

<!--suppress ALL -->


<div class="products-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?= $title ?></h4>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'product-edit',
                'action' => 'blockedtimes?prodId=' . $currentProduct->id,
                'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],

            ]);

            echo $form->field($model, 'date')->widget(DateTimePicker::class, [
                //'id' => 'products-blockoutsdates',

                'type' => DateTimePicker::TYPE_INLINE,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh:ii',
                    'autoclose' => true,
                ]
            ]);

            if (isset($returnMessage)) {
                Yii::$app->session->setFlash('info', $returnMessage);
                echo \insolita\wgadminlte\FlashAlerts::widget([
                    'errorIcon' => '<i class="fa fa-warning"></i>',
                    'successIcon' => '<i class="fa fa-check"></i>',
                    'successTitle' => 'Done!', //for non-titled type like 'success-first'
                    'closable' => true,
                    'encode' => false,
                    'bold' => false,
                ]);
            }

            ?>


            <div class="form-group">
                <br/>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Future Blockouts</h4>
            </div>
            <div class="panel-body">
                <?php

                $gridColumns = [
                    'id',
                    'product_id',
                    'date',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{delete}',

                        'urlCreator' => function ($action, $model, $key, $index) { return '?' . $action . '=' . $model->id . '&prodId=' . $model->product_id; },
                        'viewOptions' => ['title' => 'This will launch the book details page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
                        'deleteOptions' => ['title' => 'This will launch the book delete action. Disabled for this demo!', 'data-toggle' => 'tooltip'],

                    ],

                ];

                echo \kartik\grid\GridView::widget([
                    'id' => 'kv-grid-demo',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                    'pjax' => true, // pjax is set to always true for this demo
                    // set your toolbar
                    // set export properties
                    'export' => [
                        'fontAwesome' => true
                    ],
                    // parameters from the demo form
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'showPageSummary' => true,

                    'persistResize' => false,

                    'itemLabelSingle' => 'timeblock',
                    'itemLabelPlural' => 'timeblocks'
                ]);

                ?>

            </div>

        </div>

    </div>
</div>



