<?php



backend\

/* @var $this yii\web\View */

backend\
/* @var $form yii\bootstrap\ActiveForm */


/* @var $model app\models\LoginForm */





use yii\helpers\Html;


use yii\bootstrap\ActiveForm;


//use app\modules\Users\Module as Usermodule;





$this->title = Yii::t('app','Jelszó megváltoztatása');


$this->params['breadcrumbs'][] = $this->title;


?>


<div class="site-login">


    <h1><?= Html::encode($this->title) ?></h1>





    <?php


    //Yii::$app->extra->e(Yii::$app->session);


    if(Yii::$app->session->hasFlash('success'))


    {


        echo '<p class="has-success"><span class="help-block help-block-success">'.Yii::$app->session->getFlash('success').'</span></p>';


    }


    ?>





    <p><?= Yii::t('app','A jelszó megváltoztatásához előbb adja meg a régi jelszavát') ?>:</p>





    <?php $form = ActiveForm::begin([


        'id' => 'registration-form',


        'options' => ['class' => 'registration-form form-horizontal'],


        'fieldConfig' => [


            'template' => "<div class=\"row\">{input}</div>\n<div class=\"row\">{error}</div>",


            'labelOptions' => ['class' => 'col-lg-1 control-label'],


        ],


    ]); ?>


        


        <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder'=>Yii::t('app', 'RÉGI JELSZÓ')]) ?>





        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ')]) ?>


    


        <?= $form->field($model, 'verifyPassword')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ ÚJRA')]) ?>





        <div class="form-group">


            <?= Html::submitButton(Yii::t('app','Jelszó megváltoztatása'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>


        </div>





    <?php ActiveForm::end(); ?>





</div>


