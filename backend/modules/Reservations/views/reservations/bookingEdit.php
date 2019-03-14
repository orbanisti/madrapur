<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\Reservations\models\ReservationsAdminSearchModel */
/* @var $form ActiveForm */
?>
<div class="bookingEdit">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'bookingId') ?>
        <?= $form->field($model, 'source') ?>
        <?= $form->field($model, 'data') ?>
        <?= $form->field($model, 'invoiceDate') ?>
        <?= $form->field($model, 'bookingDate') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- bookingEdit -->
