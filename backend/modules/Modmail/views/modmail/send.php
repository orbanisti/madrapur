<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 8/13/2019
 * Time: 3:31 PM
 */

use kartik\form\ActiveForm;

?>

<div class="modmail-default-index">
    <div class="panel">

        <div class="panel-heading">
            <h3>Send mail</h3>
        </div>
        <div class="panel-body">
            <?php


            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
            ]) ?>
            <?= $form->field($model, 'from')->textInput(['value'=>$data['from'], 'required' => true])
            ; ?>
            <?= $form->field($model, 'to')->textInput(['value' => $data['to'], 'required' => true]); ?>
            <?= $form->field($model, 'subject')->textInput(['value' => $data['subject'], 'required' => true]); ?>
            <?= $form->field($model, 'type')->hiddenInput(['value' => $data['type']])->label(''); ?>

            <?php
            foreach ($templateFields as $field) {
            ?>
                <div class="form-group">
                    <div class="col-lg-4 col-lg-12">
                    <?= \yii\helpers\Html::label($field) ?>
                    <?= \yii\helpers\Html::textInput($field, "", []) ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="form-group">
                <div class="col-lg-4 col-lg-12">
                    <?= \yii\helpers\Html::submitButton('Send now', ['class' => 'btn btn-primary', 'name' => 'sendNow', 'value' =>
                        'sendNow']) ?>
                </div>

                <div class="col-lg-4 col-lg-12">
                    <?= \yii\helpers\Html::submitButton('Preview', ['class' => 'btn btn-secondary', 'name' => 'preview', 'value' =>
                        'preview']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>




        </div>



    </div>
</div>
