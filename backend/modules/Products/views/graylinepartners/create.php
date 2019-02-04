<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\Products\models\Graylinepartners */

$this->title = Yii::t('app', 'Partner létrehozása');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grayline partnerek'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graylinepartners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
