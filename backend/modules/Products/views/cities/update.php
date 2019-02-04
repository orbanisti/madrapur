<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Cities */

$this->title = Yii::t('app', 'Város szerkesztése'). ' "' . $model->name. '"';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Városok'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztás');
?>
<div class="cities-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTranslations' => $modelTranslations
    ]) ?>

</div>
