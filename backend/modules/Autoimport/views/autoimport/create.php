<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\AutoImport\models\Autoimport $model
 */

$this->title = 'Create Autoimport';
$this->params['breadcrumbs'][] = ['label' => 'Autoimports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autoimport-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
