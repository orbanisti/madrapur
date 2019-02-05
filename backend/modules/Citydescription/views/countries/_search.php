<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Citydescription\models\CountriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'country_code') ?>

    <?= $form->field($model, 'country_name') ?>

    <?= $form->field($model, 'currency_code') ?>

    <?= $form->field($model, 'population') ?>

    <?php // echo $form->field($model, 'fips_code') ?>

    <?php // echo $form->field($model, 'capital') ?>

    <?php // echo $form->field($model, 'area_size') ?>

    <?php // echo $form->field($model, 'iso_name') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'link') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
