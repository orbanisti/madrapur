<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\AutoImport\models\Autoimport $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="autoimport-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'siteUrl' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Site Url...','rows' => 6]],

            'apiUrl' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Api Url...','rows' => 6]],

            'type' => ['type' => Form::INPUT_DROPDOWN_LIST,'items'=>['booking'=>'booking'],'options' => ['placeholder' => 'Enter 
    Type...',
            'rows' =>
                6]],

            'active' => ['type' => Form::INPUT_DROPDOWN_LIST,
                         'options' => ['placeholder' => 'Enter Active...'],
                         'items'=>[0,1],
            ],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
