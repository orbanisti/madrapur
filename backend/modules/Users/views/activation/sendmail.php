<?php



/* @var $this ybackend\eb\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;



$this->title = 'Aktiváló email';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>



    <p>Please fill out the following fields to login:</p>



    <?php

    if(Yii::$app->session->hasFlash('error'))

    {

        echo '<p class="has-error"><span class="help-block help-block-error">'.Yii::$app->session->getFlash('error').'</span></p>';

    }

    ?>

    

    <?php $form = ActiveForm::begin([

        'id' => 'activation-form',

        'options' => ['class' => 'form-horizontal'],

        'fieldConfig' => [

            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",

            'labelOptions' => ['class' => 'col-lg-1 control-label'],

        ],

    ]); ?>



        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>





        <div class="form-group">

            <div class="col-lg-offset-1 col-lg-11">

                <?= Html::submitButton('Email kiküldése', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

            </div>

        </div>



    <?php ActiveForm::end(); ?>



</div>

