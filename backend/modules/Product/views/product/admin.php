<?php
use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;

?>

<div class="product-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'id',

            'title',
            'capacity',
            'currency',
            [
                'label' => 'Edit Product',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Reservations/reservations/bookingedit?bookingId='.''/*$model->returnBookingId()*/.'">Edit'.'</a>';
                }
            ],

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
    </p>
</div>
