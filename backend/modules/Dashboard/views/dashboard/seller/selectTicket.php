<?php
/**
 * @var $selectTicket
 */
?>

<h1>SelectTicket</h1>
<div class="col-xs-12 col-md-3">
    <?php


    if ($selectTicket) {
        echo \kartik\grid\GridView::widget([
            'pager' => [
                'firstPageLabel' => Yii::t('app', 'Első oldal'),
                'lastPageLabel' => Yii::t('app', 'Utolsó oldal'),
            ],
            'dataProvider' => $selectTicket->dataProvider,
            'filterModel' => $selectTicket->searchModel,
            'columns' => $selectTicket->gridColumns,
        ]);
    }

    ?>
</div>