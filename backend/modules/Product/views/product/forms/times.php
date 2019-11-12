<?php


use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_times', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.card-body.main-times', // required: css class selector
    'widgetItem' => '.item-times', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item-times', // css class
    'deleteButton' => '.remove-item-times', // css class
    'model' => $modelTimes[0],
    'formId' => 'product-edit',
    'formFields' => [
        'name',
    ],
]);
?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="add-item-sources btn btn-info btn-sm pull-right"><i
                                class="fa fa-plus fa-fw"></i> <?= Yii::t('app', 'New Time') ?></button>
                </h3>
                ​
                <div class="card-tools">
                    <button type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    ​
                </div>
            </div>
            <div class="card-body main-times">
                ​<?php foreach ($modelTimes as $i => $modelTime): ?>
                    <div class="row item-times">
                        <div class="col-12">
                            <!-- interactive chart -->
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?= $modelTime->name ?>
                                    </h3>
                                    ​
                                    <div class="card-tools">
                                        <button type="button"
                                                class="btn btn-tool"
                                                data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        ​
                                        <button type="button"
                                                class="close"
                                                aria-label="Close"
                                                data-card-widget="close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // necessary for update action.

                                    echo Html::activeHiddenInput($modelTime, "[{$i}]id");

                                    echo $form->field($modelTime, "[{$i}]product_id")->hiddenInput(['value' => $model->id])->label(false);
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($modelTime, "[{$i}]name")->textInput(['class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-12">

                                        </div>
                                        <div class="col-sm-6">

                                            <?= $form->field($modelTime, "[{$i}]start_date")->widget(DateControl::class, [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'autoWidget' => true,
                                                'displayFormat' => 'php:Y-m-d',
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
                                            ]); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelTime, "[{$i}]end_date")->widget(DateControl::class, [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'autoWidget' => true,
                                                'displayFormat' => 'php:Y-m-d',
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
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
