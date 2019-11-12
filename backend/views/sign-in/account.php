<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
?>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cogs  "></i>
                    <?=Yii::t('backend', 'Edit account')?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="user-profile-form">

                    <?php $form = ActiveForm::begin() ?>

                    <?php echo $form->field($model, 'username') ?>

                    <?php echo $form->field($model, 'email') ?>

                    <?php echo $form->field($model, 'password')->passwordInput() ?>

                    <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>

                    <div class="form-group">
                        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
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