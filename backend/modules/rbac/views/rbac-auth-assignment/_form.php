<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\rbac\models\RbacAuthAssignment */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="rbac-auth-assignment-form">

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
