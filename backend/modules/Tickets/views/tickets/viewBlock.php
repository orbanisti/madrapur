<div class="tickets-view-block">
    <?php

        use yii\bootstrap4\Html;



    ?>
    <?php
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'pjax' => true,
        'toolbar' => [
            [
                'content' =>
                    Html::button('<i class="fas fa-plus"></i>', [
                        'class' => 'fa fa-ticket',
                        'title' => Yii::t('kvgrid', 'Add Book'),
                        'onclick' => 'alert("This will launch new booking creation!");'
                    ]) . ' ' .
                    Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                        'class' => 'btn btn-outline-secondary',
                        'title' => Yii::t('kvgrid', 'Reset Grid'),

                        'options' => ['class' => 'btn-group mr-2']
                    ])
            ],
            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'fontAwesome' => true,
        ],
        'bordered' => true,
        'striped' => false,
        'rowOptions'=>function(\backend\modules\Tickets\models\TicketSearchModel $model){
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
        'panel' => [
            'heading' => '<i class="fa fa-summary-alt"></i>',
        ],
    ]);
    ?>
</div>
