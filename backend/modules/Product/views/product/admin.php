<?php
use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;

?>

<div class="product-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
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
                    return '<a href="/Product/product/create">Edit'.'</a>';
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
