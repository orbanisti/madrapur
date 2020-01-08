<?php

    use backend\modules\Product\models\AddOn;
    use backend\modules\Product\models\Product;
    use backend\modules\Product\models\ProductAddonBlockout;
    use kartik\helpers\Html;
    use kartik\widgets\ActiveForm;
    use kartik\widgets\DatePicker;

?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Block addons of <?=

                        \backend\modules\Product\models\Product::findOne($prodId)->title?>
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
                                    $model=new ProductAddonBlockout();

                                    $form = ActiveForm::begin([
                                                                  'id' => 'product-edit',

                                                                  'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],

                                                              ]);
                                    echo $form->field($model, 'startDate')->widget(DatePicker::class, [
                                        //'id' => 'products-blockoutsdates',

                                        'type' => DatePicker::TYPE_INLINE,
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                            'autoclose' => true,
                                        ]
                                    ]);
                                    echo $form->field($model,'addonId')->dropDownList
                                    (
                                        Product::getAddons($prodId))->label(false);



                                ?>

                                <div class="form-group">
                                    <br/>
                                    <?php echo  Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') :
                                                                       Yii::t('app', 'Update'), ['class' => 'btn btn-info']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <div class="col-lg-6">
                                <div class="border border-secondary rounded p-1 panel-body panel-default ">
                                    <div class="panel-heading">
                                        <h4>Future Blockouts</h4>
                                    </div>
                                    <div class="panel-body">

                                        <div class="panel-body">
                                            <span> Connected:


                                            <?php
                                                foreach($sources as $source){
                                                    echo ' <a class="badge-pill badge badge-info">'.$source.'</a>';

                                                }

                                            ?>
                                            </span>
                                        </div>
                                        <?php

                                            $gridColumns = [

                                                [
                                                    'attribute'=>'id',
                                                    'visible'=>false,
                                                ],
                                                [
                                                    'attribute'=>'startDate',
                                                    'visible'=>true,
                                                ],
                                                [
                                                    'attribute'=>'addonId',
                                                    'visible'=>true,
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return (AddOn::findOne($model->addonId))->name;
                                                    },
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'template' => '{delete}',

                                                    'urlCreator' => function ($action, $model, $key, $index) { return
                                                        '?' . $action . '=' . $model->id . '&prodId=' .
                                                        $model->productId; },
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

