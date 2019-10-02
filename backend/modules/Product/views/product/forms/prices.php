<?php

use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 999, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $modelPrices[0],
            'formId' => 'product-edit',
            'formFields' => [
                'name',
                'description',
            ],
        ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-euro"></i> <?= Yii::t('app', 'Product $Prices') ?>    <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
                    <button type="button" class="add-item btn btn-info btn-sm pull-right"><i
                                class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelPrices as $i => $modelPrice): $uniqid = uniqid(); ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Ár') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-info btn-xs"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                                class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="tabs<?= $uniqid ?>" class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#prices<?= $uniqid ?>" data-toggle="tab"
                                                          class="pricestab"><?= Yii::t('app', 'Tartalom') ?></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="prices<?= $uniqid ?>">
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


                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>
        <?php DynamicFormWidget::end(); ?>