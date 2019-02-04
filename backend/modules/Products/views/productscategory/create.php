<?php



use yii\helpers\Html;

backend\



/* @var $this yii\web\View */

/* @var $model app\modules\Products\models\Productscategory */



$this->title = Yii::t('app', 'Kategória létrehozása');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kategóriák'), 'url' => ['admin']];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="productscategory-create">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

        'modelTranslations' => $modelTranslations

    ]) ?>



</div>

