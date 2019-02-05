<?php



use yii\helpers\Html;


/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Services */



$this->title = Yii::t('app', 'Szolgáltatás szerkesztése'). ' "' . $model->name. '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Szolgáltatások'), 'url' => ['admin']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztás');

?>

<div class="services-update">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

        'modelTranslations' => $modelTranslations

    ]) ?>



</div>

