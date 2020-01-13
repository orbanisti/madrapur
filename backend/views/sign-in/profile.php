<?php
use common\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle  "></i>
                    <?=Yii::t('backend', 'Edit profile')?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="user-profile-form">

                    <?php $form = ActiveForm::begin() ?>

                    <?php

                        echo $form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::class, [
                            'url' => [
                                'avatar-upload'
                            ]
                        ])?>

                    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

<!--                    --><?php //echo $form->field($model, 'middlename')->textInput(['maxlength' => 255]) ?>

                    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

                    <?php echo $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

                    <?php

                        echo $form->field($model, 'gender')->dropDownlist(
                            [
                                UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                                UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                            ])?>

                    <div class="form-group">
                        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary ']) ?>
                    </div>

                    <?php ActiveForm::end() ?>

                </div>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>

