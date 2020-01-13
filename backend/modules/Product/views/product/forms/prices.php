<?php

use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

$this->registerJs('
    $(".close").on("click",function() {
      $(this).closest(".card").fadeOut();
    })
');

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.card-body.main', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 999, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.close', // css class
    'model' => $modelPrices[0],
    'formId' => 'product-edit',
    'formFields' => [
        'name',
        'description',
    ],
]); ?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="add-item btn btn-info btn-sm pull-right"><i
                                class="fa fa-plus fa-fw"></i> <?= Yii::t('app', 'New Price') ?></button>
                </h3>
                ​
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body main">
                ​<?php foreach ($modelPrices as $i => $modelPrice): $uniqid = uniqid(); ?>
                    <div class="row item">
                        <div class="col-12">
                            <!-- interactive chart -->
                            <div class="card card-secondary card-outline" id="prices<?= $uniqid ?>">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?= $modelPrice->name ?>
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

                                        ​
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // necessary for update action.

                                    echo Html::activeHiddenInput($modelPrice, "[{$i}]id");

                                    ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrice, "[{$i}]name")->textInput(); ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrice, "[{$i}]description")->textInput(); ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?= $form->field($modelPrice, "[{$i}]price")->textInput(); ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrice, "[{$i}]discount")->textInput() ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrice, "[{$i}]start_date")->widget(DateControl::class, [
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
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrice, "[{$i}]end_date")->widget(DateControl::class, [
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
                                    </div>

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