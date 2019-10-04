<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\Modevent\models\Modevent $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="modevent-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter ID...']],

            'title' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter title...','rows' => 6]],

            'place' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter place...','rows' => 6]],

            'user' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter user...','rows' => 6]],

            'status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter status...']],

            'date' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
