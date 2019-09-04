<?php

use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\select2\Select2;

?>

<h1>Add ticket block</h1>

<div class="panel">
    <div class="panel-body">
        <?php

        $form = ActiveForm::begin([
            'id' => 'add-ticket-block',
            'class' => 'form-inline'
        ]);

        ?>

        <div class="form-group">
            <?= $form->field($model, 'startId', [
                'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group"><span class="input-group-addon">ID</span>{input}</div>{error}{hint}',
                'hintType' => \kartik\form\ActiveField::HINT_DEFAULT,
                'hintSettings' => ['onLabelClick' => false, 'onLabelHover' => true, 'onIconHover' => true,]
            ])->textInput(['placeholder' => 'First ID.', 'name' => 'startId', 'id' =>
                'startId', 'maxlength' => 8, 'pattern' => '\d*', 'required' => true])->hint
            ('Entering the full ticket ID is mandatory. In case of voucher ticket block include the initial letter, too.') ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'assignedTo')->widget(Select2::class, [
                'name' => 'assignedTo',
                'data' => $users,
                'options' => [
                    'placeholder' => 'Select a user.',
                    'required' => true
                ],
            ]) ?>
            <?php

            ?>
        </div>

        <?php
        echo Html::submitButton(
            Yii::t('backend', 'Add ticket block'),
            [
                'class' => 'btn btn-primary btn-flat btn-block',
                'name' => 'add-ticket-block-button'
            ]
        );

        ?>

        <?php ActiveForm::end() ?>
    </div>
</div>