<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Blockouts */

$this->title = Yii::t('app', 'Új időpont tíltás');
?>
<div class="blockouts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
