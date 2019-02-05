<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Citydescription\models\Countries */

$this->title = $model->country_name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Országok'), 'url' => ['admin']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztés');
?>
<div class="countries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTranslations' => $modelTranslations
    ]) ?>

</div>
