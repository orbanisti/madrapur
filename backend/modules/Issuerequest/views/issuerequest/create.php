<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\Issuerequest\models\Issuerequest $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Issuerequest',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Issuerequests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuerequest-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
