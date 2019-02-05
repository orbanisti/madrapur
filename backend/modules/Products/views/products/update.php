<?php



use yii\helpers\Html;



/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Products */



$this->title = Yii::t('app', 'Termék szerkesztése') . ' "'.$model->name.'"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Termékek'), 'url' => ['admin']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztés');

?>

<div class="products-update">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

        'modelTranslations' => $modelTranslations,

        'modelPrices' => $modelPrices,
        'modelTimes' => $modelTimes

    ]) ?>



</div>

