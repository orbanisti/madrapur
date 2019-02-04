<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Productscategory */

$this->title = Yii::t('app', 'Kategória szerkesztése') . ' "'.$model->name.'"';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kategóriák'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztés');
?>
<div class="productscategory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTranslations' => $modelTranslations
    ]) ?>

</div>
