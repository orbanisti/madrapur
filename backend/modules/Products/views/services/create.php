<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Services */

$this->title = Yii::t('app', 'Új szolgáltatás');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Szolgáltatások'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTranslations' => $modelTranslations
    ]) ?>

</div>
