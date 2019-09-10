<?php

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'pjax' => true,
    'toolbar' => [],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'export' => [
        'fontAwesome' => true,
    ],
    'bordered' => false,
    'striped' => false,
    'rowOptions'=>function(\backend\modules\Reservations\models\Reservations $model){
        switch ($model->status) {
            case 'skipped':
                $rowClass = 'warning';
                break;
            case 'sold':
                $rowClass = 'success';
                break;
            case 'open':
            default:
                $rowClass = '';
                break;
        }

        return ['class' => $rowClass];
    },
]);