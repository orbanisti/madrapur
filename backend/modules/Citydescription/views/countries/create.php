<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\Citydescription\models\Countries */

$this->title = Yii::t('app', 'Új ország');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Országok'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTranslations' => $modelTranslations
    ]) ?>

</div>
