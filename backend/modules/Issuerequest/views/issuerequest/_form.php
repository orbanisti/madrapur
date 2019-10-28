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


    <?php $form = ActiveForm::begin() ?>



    <?php echo $form->field($model, 'content')->textarea(['rows'=>6])->label('Message') ?>



        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'priority')->dropDownList(array('High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low',
                                                                   ), array('options' =>
                                                                                array
                                                                                ('Medium' => array('selected' => true)))); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'category')->dropDownList(['Street' => 'Street', 'Hotel' => 'Hotel', 'Web'
                                                                   => 'Web', 'Partner' =>
                    'Partner', 'Other' => 'Other'
                                                                   ],['options' =>
                                                                               ['Other' => ['selected' => true]]])
                ; ?>
            </div>
            <div class="col-sm-4">
                <?=$form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::class, [
                    'url' => [
                        'avatar-upload'
                    ],

                ])->label('Image')?>
            </div>
            
        </div>



    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', '<i class="fas fa-paper-plane  "></i>Create Issue'), ['class' => 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end() ?>


</div>
