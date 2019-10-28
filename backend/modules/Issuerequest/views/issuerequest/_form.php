<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\Issuerequest\models\Issuerequest $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="issuerequest-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'content' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Content...','rows' => 6]],

            'image' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Image...','rows' => 6]],

            'priority' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Priority...','rows' => 6]],

            'status' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Status...','rows' => 6]],

            'assignedUser' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Assigned User...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
