<?php

use backend\components\extra;

?>

<div class="product-default-index">

    <?php
    /*
        $client = new \nizsheanez\jsonRpc\Client('http://localhost/Product/product/admin');

        $response = $client->sum(2, 3);
        echo $response;*/
    ?>
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
            'format' => 'html',
            'value' => function ($model) {
                return '<a href="/Product/product/update?prodId=' . $model->id . '">Edit' . '</a>';
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
    // $prodInfo=Product::getProdById(43); //With this method you get every information about a product with $id

    ?>
    </p>
</div>
