<?php



/* @var $this ybackend\eb\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;



$this->title = $title;

$this->params['breadcrumbs'][] = $title;

?>

<div class="site-message">

    <h1><?= Html::encode($title) ?></h1>

    <p><?= $message; ?></p>

</div>

