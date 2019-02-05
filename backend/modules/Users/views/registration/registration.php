<?phpbackend\backend\



/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use app\modules\Users\Module as Usermodule;



$this->title = 'Regisztráció';

$this->params['breadcrumbs'][] = $this->title;

?>

<script>

    $('#mymodalcontent').addClass('transparent-modal');

</script>

<div class="site-login">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?php

    echo Html::a(Html::button(Yii::t('app', 'Felhasználó').'<br/><span>'.Yii::t('app', 'Regisztráció').'</span>', ['class' => 'btn btn-reg']),Usermodule::$userregistrationUrl);

    echo Html::a(Html::button(Yii::t('app', 'Partner').'<br/><span>'.Yii::t('app', 'Regisztráció').'</span>', ['class' => 'btn btn-reg btn-reg-partner']),Usermodule::$partnerregistrationUrl);

    ?>

    <br/><br/>

</div>

