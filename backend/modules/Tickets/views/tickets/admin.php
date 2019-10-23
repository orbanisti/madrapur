<?php

?>


<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Ticket Viewer
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="card-body">



        <div class="tickets-admin">
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

    </div>
    <!-- /.card-body-->
</div>
