<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\Modevent\models\Modevent $model
 */

$this->title = 'Update Modevent: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Modevents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modevent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
