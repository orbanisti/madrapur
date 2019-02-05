<?php



backend\

/* @var $this yii\web\View */


/* @var $form yii\bootstrap\ActiveForm */


/* @var $model app\models\LoginForm */





use yii\helpers\Html;


use yii\bootstrap\ActiveForm;





$this->title = Yii::t('app','Jelszó helyreállító email');


$this->params['breadcrumbs'][] = $this->title;


?>


<div class="site-login">


    <h1><?= Html::encode($this->title) ?></h1>





    <p><?= Yii::t('app','Adja meg az emil címét, a jelszó helyreállításához') ?>:</p>





    <?php


    if(Yii::$app->session->hasFlash('error'))


    {


        echo '<p class="has-error"><span class="help-block help-block-error">'.Yii::$app->session->getFlash('error').'</span></p>';


    }


    ?>


    


    <?php $form = ActiveForm::begin([


        'id' => 'activation-form',


        'options' => ['class' => 'registration-form form-horizontal'],


        'fieldConfig' => [


            'template' => "<div class=\"row\">{input}</div>\n<div class=\"row\">{error}</div>",


            'labelOptions' => ['class' => 'col-lg-1 control-label'],


        ],


    ]); ?>





        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>Yii::t('app', 'EMAIL CÍM')]) ?>





        <div class="form-group">


            <?= Html::submitButton(Yii::t('app','Email kiküldése'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>


        </div>





    <?php ActiveForm::end(); ?>





</div>


