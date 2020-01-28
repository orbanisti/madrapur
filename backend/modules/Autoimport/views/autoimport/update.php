<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\AutoImport\models\Autoimport $model
 */

$this->title = 'Update Autoimport: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Autoimports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="autoimport-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
