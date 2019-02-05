<?php



/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model backend\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use yii\helpers\Url;

use backend\modules\Users\Module as Usermodule;
use kartik\social\Module;


$this->title = Yii::t('app', 'Bejelentkezés');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>



    <p><?= Yii::t('app', 'Kérjük, töltse ki az alábbi mezőket a bejelentkezéshez') ?>:</p>



    <?php

    if (Yii::$app->session->hasFlash('error')) {

        echo '<p class="has-error"><span class="help-block help-block-error">' . Yii::$app->session->getFlash('error') . '</span></p>';

    }

    ?>



    <?php $form = ActiveForm::begin([

        'id' => 'login-form',

        'options' => ['class' => 'registration-form form-horizontal'],

        'fieldConfig' => [

            'template' => "<div class=\"row\">{input}</div>\n<div class=\"row\">{error}</div>",

            'labelOptions' => ['class' => 'col-lg-1 control-label'],

        ],

    ]); ?>



    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'FELHASZNÁLÓNÉV')]) ?>



    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'JELSZÓ')]) ?>



    <?= $form->field($model, 'rememberMe')->checkbox([

        'template' => "<div class=\"row uppercase checkbox checkbox-mandelan\">{input} {label}</div>\n<div class=\"row\">{error}</div>",

    ]) ?>



    <?= Html::a(Yii::t('app', 'Elfelejtettem a jelszavamat'), Yii::$app->urlManager->createAbsoluteUrl(['users/recovery/recovery']), ['class' => 'uppercase']) ?>



    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Bejelentkezés'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    </div>
    
    <?php
        $social = Yii::$app->getModule('social');
        $callback = Url::to(Usermodule::$loginfbUrl, true); // or any absolute url you want to redirect
        echo $social->getFbLoginLink($callback, ['class'=>'btn btn-primary']);
    ?>

    <div class="form-group">

        <?= '<a class="btn btn-primary" data-toggle="modal" href="' . Url::to(Usermodule::$registrationUrl) . '" data-target="#myModal">' . Yii::t('app', 'Regisztráció') . '</a>'; ?>

    </div>

    <?php ActiveForm::end(); ?>



</div>

