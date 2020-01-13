

<?php


use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_sources', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.card-body.main-sources', // required: css class selector
    'widgetItem' => '.item-sources', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item-sources', // css class
    'deleteButton' => '.remove-item-sources', // css class
    'model' => $modelSources[0],
    'formId' => 'product-edit',
    'formFields' => [
        'name',
    ],
]);
?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info container-items-sources">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="add-item-sources btn btn-info btn-sm pull-right"><i
                                class="fa fa-plus fa-fw"></i> <?= Yii::t('app', 'New Source') ?></button>
                </h3>
                ​
                <div class="card-tools">
                    ​
                </div>
            </div>
            <div class="card-body main-sources">
                ​
                <?php foreach ($modelSources as $i => $modelSource): ?>
                    <div class="row item-sources">
                        <div class="col-12">
                            <!-- interactive chart -->
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?= $modelSource->name ?>
                                    </h3>
                                    ​
                                    <div class="card-tools">
                                        <button type="button"
                                                class="btn btn-tool"
                                                data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <button type="button"
                                                class="close"
                                                aria-label="Close"
                                                data-card-widget="close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    ​<?php
                                    // necessary for update action.

                                    echo Html::activeHiddenInput($modelSource, "[{$i}]id");

                                    echo $form->field($modelSource, "[{$i}]product_id")->hiddenInput(['value' => $model->id])->label(false);
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($modelSource, "[{$i}]name")->textInput(['class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <?= $form->field($modelSource, "[{$i}]url")->textInput(['class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <?= $form->field($modelSource, "[{$i}]prodIds")->textInput(['class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <?= $form->field($modelSource, "[{$i}]color")->widget(\kartik\color\ColorInput::class, [
                                                'options' => ['placeholder' => 'Select color ...'],
                                            ]); ?>
                                        </div>
                                    </div><!-- .row -->

                                </div>
                                <!-- /.card-body-->
                            </div>
                            <!-- /.card -->
                            ​
                        </div>

                        <!-- /.col -->
                    </div>

                <?php endforeach; ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->
        ​
    </div>

    <!-- /.col -->
</div>

<?php DynamicFormWidget::end(); ?>

<?php
$this->registerJs('
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        console.log("beforeInsert");
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        console.log("afterInsert");
        /*list=item.getElementsByTagName("input");
        for (var i = 0; i < list.length; i++) {
            console.log(list[i].id); //second console output
            //console.log(list[i].value);
        }*/
        list=item.getElementsByClassName("tab-pane");
        for (var i = 0; i < list.length; i++) {
            var arr = list[i].id.split("-");
            if(arr[0]=="pricestranslate")
                $(".pricestranslatetab").last().attr("href","#"+list[i].id);
            else
                $(".pricestab").last().attr("href","#"+list[i].id);
        }
    });
    ');


?>
