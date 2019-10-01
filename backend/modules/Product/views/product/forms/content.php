<?php
use kartik\helpers\Html;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
?>
<div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Product Details') ?>
                    <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
                </h4>
            </div>
            <div class="panel-body">


                <?= $form->field($model, 'currency')->dropDownList(array('HUF' => 'HUF', 'EUR' => 'EUR',), array('options' => array('HUF' => array('selected' => true)))); ?>
                <?= $form->field($model, 'status')->dropDownList(array('active' => 'active', 'inactive' => 'inactive',), array('options' => array('active' => array('selected' => true)))); ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->widget(froala\froalaeditor\FroalaEditorWidget::className(), [
                    'clientOptions' => [

                        'toolbarInline' => false,

                        'theme' => 'royal', //optional: dark, red, gray, royal
                        'language' => 'en_gb' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
                    ]
                ]) ?>
                <?= $form->field($model, 'short_description')->widget(froala\froalaeditor\FroalaEditorWidget::className(), [
                    'clientOptions' => [
                        'toolbarInline' => false,
                        'theme' => 'royal', //optional: dark, red, gray, royal
                        'language' => 'en_gb' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
                    ]
                ]) ?>
                <?= $form->field($model, 'category')->textInput(['maxlenght' => 60]) ?>
                <?= $form->field($model, 'capacity')->textInput(['maxlenght' => 60]) ?>
                <?= $form->field($model, 'duration')->textInput(['maxlenght' => 60]) ?><?= '(in minutes)' ?>
                <?= $form->field($model, 'thumbnail')->textInput(['maxlenght' => 255]) ?>

                <?= $form->field($model, 'images')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png'], 'showUpload' => false]
                ]) ?>

                <?php // (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['productsPictures'] . $model->image, ['style'=>'max-width: 300px;']):''; ?>



                <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
                    'ajaxConversion' => false,
                    'autoWidget' => true,
                    'displayFormat' => 'php:Y-m-d',
                    'type' => DateControl::FORMAT_DATE,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>

                <?= $form->field($model, 'end_date')->widget(DateControl::classname(), [
                    'ajaxConversion' => false,
                    'autoWidget' => true,
                    /*'displayFormat' => 'php:Y-m-d H:i',
                    'type'=>DateControl::FORMAT_DATETIME,*/
                    'displayFormat' => 'php:Y-m-d',
                    'type' => DateControl::FORMAT_DATE,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>


                <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary']) ?>

            </div>
        </div>