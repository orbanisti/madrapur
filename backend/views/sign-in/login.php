<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->title = Yii::t('backend', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';

?>
<div class="login-box">
	<div class="login-logo">
        <?php echo Html::encode($this->title) ?>
    </div>
    <div class="row">
        <div class="col-12">
            <!-- interactive chart -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">

                    </h3>

                    <div class="card-tools">


                    </div>
                </div>
                <div class="card-body">
                    <div class="login-box-body">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <div class="body">
                            <?php echo $form->field($model, 'username') ?>
                            <?php echo $form->field($model, 'password')->passwordInput() ?>
                                <div class="icheck-primary">
                                    <?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'simple']) ?></div>

                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" checked="checked" />
                                    <span>Filled in</span>
                                </label>
                            </p>
                        </div>
                        <div class="footer">
                            <?php

                                echo Html::submitButton(Yii::t('backend', 'Sign me in'),
                                    [
                                        'class' => 'btn btn-primary btn-flat btn-block',
                                        'name' => 'login-button'
                                    ])?>
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


	<!-- /.login-logo -->
	<div class="header"></div>


</div>