<?php

use backend\components\extra;
use kartik\helpers\Html;

$this->title = Yii::t('app', 'Fizetések');
$this->params['breadcrumbs'][] = $this->title;
?>

    <!--suppress ALL -->
    <div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php
$gridColumns = [
    'id',
    'transactionId',
    'reservationIds',
    'status',
];

echo \yii\grid\GridView::widget([
    'pager' => [
        'firstPageLabel' => Yii::t('app', 'Első oldal'),
        'lastPageLabel' => Yii::t('app', 'Utolsó oldal'),
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
]);

?>