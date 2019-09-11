<div class="tickets-view-assigned-block">
    <?php
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'toolbar' => [
            [
                'options' => ['class' => 'btn-group mr-2']
            ],
            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'fontAwesome' => true,
        ],
        'bordered' => true,
        'striped' => true,
        'panel' => [
            'heading' => '<i class="fa fa-summary-alt"></i>',
        ],
    ]);
    ?>
</div>
