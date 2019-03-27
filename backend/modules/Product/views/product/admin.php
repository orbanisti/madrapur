<?php
use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;
use backend\modules\Product\models\Product;

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
                    return '<a href="/Product/product/update?prodId='.$model->id.'">Edit'.'</a>';
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
        $prodInfo=Product::getProdById(43);
        var_dump($prodInfo);

        ?>
    </p>
</div>
