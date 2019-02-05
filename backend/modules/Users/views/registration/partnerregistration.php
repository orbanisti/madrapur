<?phpbackend\backend\



/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use app\modules\Users\Module as Usermodule;



$this->title = Yii::t('app','Partner regisztráció');

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

        <?= $form->field($model, 'company_name')->textInput(['placeholder'=>Yii::t('app', 'CÉGNÉV')]) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ')]) ?>

    

        <?= $form->field($model, 'verifyPassword')->passwordInput(['placeholder'=>Yii::t('app', 'JELSZÓ ÚJRA')]) ?>

    

        <?= $form->field($model, 'country')->textInput(['placeholder'=>Yii::t('app', 'ORSZÁG')]) ?>

        <?= $form->field($model, 'zipcode')->textInput(['placeholder'=>Yii::t('app', 'IRÁNYÍTÓSZÁM')]) ?>

        <?= $form->field($model, 'city')->textInput(['placeholder'=>Yii::t('app', 'VÁROS')]) ?>

        <?= $form->field($model, 'address')->textInput(['placeholder'=>Yii::t('app', 'CÍM')]) ?>

    

        <?= $form->field($model, 'tax_code')->textInput(['placeholder'=>Yii::t('app', 'ADÓSZÁM')]) ?>

        <?= $form->field($model, 'bank_acc_number')->textInput(['placeholder'=>Yii::t('app', 'BANKSZÁMLASZÁM')]) ?>

        <?= $form->field($model, 'reg_code')->textInput(['placeholder'=>Yii::t('app', 'REGISZTRÁCIÓS SZÁM')]) ?>



        <div class="form-group">

            <?= Html::submitButton(Yii::t('app', 'Regisztráció'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        </div>

    

        <?= $form->field($model, 'type', ['template'=>''])->hiddenInput(['value'=>Usermodule::TYPE_PARTNER,])->label(false); ?>



    <?php ActiveForm::end(); ?>



</div>

