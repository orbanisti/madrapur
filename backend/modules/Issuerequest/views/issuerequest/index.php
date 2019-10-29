<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Issuerequest\models\IssuerequestSearch $searchModel
 */

$this->title = Yii::t('backend', 'Issuerequests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuerequest-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Issuerequest',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) ?>

</div>
