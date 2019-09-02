<?php

use backend\modules\Citydescription\models\Citydescription;
use backend\modules\Citydescription\models\Countries;
use backend\modules\Product\models\ProductUpdate;
use backend\modules\Products\models\Products;
use backend\modules\Products\models\Services;
use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

\kartik\datetime\DateTimePickerAsset::register($this);
//backend\assets\DatetimepickerAsset::register($this);
?>

<?php
if (Yii::$app->session->hasFlash('error')) {
    echo '<p class="has-error flashes"><span class="help-block help-block-error">' . Yii::$app->session->getFlash('error') . '</span></p>';
} elseif (Yii::$app->session->hasFlash('success')) {
    echo '<p class="has-success flashes"><span class="help-block help-block-success">' . Yii::$app->session->getFlash('success') . '</span></p>';
}

$model = new ProductUpdate();

$form = ActiveForm::begin([
    'id' => 'product-update',
    'action' => 'create',
    'options' => ['class' => 'prodUpdate'],
]); ?>
<?= $form->field($model, 'currency')->dropDownList(array('HUF' => 'HUF', 'EUR' => 'EUR',), array('options' => array('HUF' => array('selected' => true)))); ?>
<?= $form->field($model, 'status')->dropDownList(array('active' => 'active', 'inactive' => 'inactive',), array('options' => array('active' => array('selected' => true)))); ?>
<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'short_description')->textarea(['rows' => 3]) ?>
<?= $form->field($model, 'category')->textInput(['maxlenght' => 60]) ?>
<?= $form->field($model, 'capacity')->textInput(['maxlenght' => 60]) ?>
<?= $form->field($model, 'duration')->textInput(['maxlenght' => 60]) ?><?= '(in minutes)' ?>

<?= $form->field($model, 'image')->widget(FileInput::classname(), [
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





<?= Html::submitButton('Termék Létrehozása', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
