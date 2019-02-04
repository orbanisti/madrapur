<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\Products\models\Graylinepartners;

/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Graylinepartners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="graylinepartners-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel')->textInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList(Graylinepartners::status()); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
