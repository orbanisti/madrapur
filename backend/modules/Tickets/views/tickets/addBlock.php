<?php

use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\select2\Select2;

?>

<?php if ($saved) { ?>
    <div class="alert alert-success" role="alert">
        Ticket block created and assigned!
    </div>
<?php } ?>

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
            <label for="startId">First ticket ID:</label>
            <?= $form->field($model, 'startId', [
                    'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group"><span class="input-group-addon">V</span>{input}</div>{error}{hint}'
            ])->textInput(['placeholder' => 'First ID.', 'name' => 'startId', 'id' =>
                'startId', 'maxlength' => 7, 'pattern' => '\d*', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="assignedTo">Assign block to:</label>
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