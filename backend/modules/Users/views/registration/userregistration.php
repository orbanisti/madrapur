<?phpbackend\backend\



/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use app\modules\Users\Module as Usermodule;
use kartik\social\Module;
use yii\helpers\Url;



$this->title = Yii::t('app','Felhasználó regisztráció');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <p><?= Yii::t('app', 'Kérjük, töltse ki az alábbi mezőket a REGISZTRÁCIÓHOZ') ?>:</p>



    <?php $form = ActiveForm::begin([

        'id' => 'registration-form',

        'options' => ['class' => 'registration-form form-horizontal'],

        'fieldConfig' => [

            'template' => "<div class=\"row\">{input}</div>\n<div class=\"row\">{error}</div>",

            'labelOptions' => ['class' => 'col-lg-1 control-label'],

        ],

    ]); ?>



        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder'=>Yii::t('app', 'FELHASZNÁLÓNÉV')]) ?>

    

        <?= $form->field($model, 'email')->textInput(['placeholder'=>Yii::t('app', 'EMAIL CÍM')]) ?>



        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ')]) ?>

    

        <?= $form->field($model, 'verifyPassword')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ ÚJRA')]) ?>



        <div class="form-group">

            <?= Html::submitButton(Yii::t('app', 'Regisztráció'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        </div>

    <?php
        $social = Yii::$app->getModule('social');
        $callback = Url::to(Usermodule::$loginfbUrl, true); // or any absolute url you want to redirect
        echo $social->getFbLoginLink($callback, ['class'=>'btn btn-primary']);
    ?>

        <?= $form->field($model, 'type', ['template'=>''])->hiddenInput(['value'=>Usermodule::TYPE_PERSON,])->label(false); ?>



    <?php ActiveForm::end(); ?>



</div>

