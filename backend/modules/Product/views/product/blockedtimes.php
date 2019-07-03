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
use kartik\grid\EditableColumn;
use backend\models\Product\Product;



$title ='Block Booking Days of '.'<u>'.$currentProduct->title.'</u>';/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/


?>

<!--suppress ALL -->


<div class="products-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?=$title?></h4>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'product-edit',
                'action' => 'blockedtimes?prodId='.$currentProduct->id,
                'options' => ['class' => 'product-edit','enctype'=>'multipart/form-data'],

            ]);


            echo $form->field($model, 'date')->widget(\kartik\datetime\DateTimePicker::class, [
                //'id' => 'products-blockoutsdates',
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh:ii',
                    'autoclose'=>true,
                ]
            ]);

            if(isset($returnMessage)){
                echo ' Successful Operation!';
            };
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

                        'urlCreator' => function($action, $model, $key, $index) { return '?'.$action.'='.$model->id.'&prodId='.$model->product_id; },
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



