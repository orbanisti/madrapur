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
    use kartik\form\ActiveForm;
    use kartik\helpers\Html;


$title = 'Block Booking Times of ' . '<u>' . $currentProduct->title . '</u>';/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/

?>

<!--suppress ALL -->


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-minus  fa-fw"></i>
                    <?= $title ?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="products-index">

                    <div class=" rounded p-1 panel panel-default ">

                        <div class="panel-body row ">

                            <div class="col-lg-3">
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



                                ?>
                                <div class="form-group">
                                    <br/>
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-info']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <div class="col-lg-6">
                                <div class="border border-secondary rounded p-1 panel-body panel-default ">
                                    <div class="panel-heading">
                                        <h4>Future Blockouts</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php

                                            $gridColumns = [

                                                [
                                                    'attribute'=>'id',
                                                    'visible'=>false,
                                                ],     [
                                                    'attribute'=>'product_id',
                                                    'visible'=>false,
                                                ],

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
                                                                                   'itemLabelPlural' => 'timeblocks',

                                                                               ]);

                                        ?>

                                    </div>

                                </div>
                            </div>



                        </div>

                    </div>


                </div>

               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>



