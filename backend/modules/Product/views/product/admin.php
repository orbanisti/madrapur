<?php

use backend\modules\Product\models\ProductSource;




?>

<div class="product-default-index">

<?php
/**
 * Json RPC Communication TODO Close this hole asap
 */
/*
 * Example of Yell function of Api Rester returns free spaces of productId on selecetedDate in Int
    $client = new \nizsheanez\jsonRpc\Client('http://www.api.localhost.com/v1/worker');
    $currentProduct=44;

    $selectedDate=date("Y-m-d");

    $response = $client->yell($selectedDate,$currentProduct);
    echo $response;
*/


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
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Product/product/update?prodId='.$model->id.'">Edit'.'</a>';
                }
            ],
            [
                'label' => 'Block Days',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Product/product/blocked?prodId='.$model->id.'">Block Days'.'</a>'
                    .'<br/><a href="/Product/product/blockedtimes?prodId='.$model->id.'">Block Times'.'</a>';
                }
            ],


        ];

        echo \kartik\grid\GridView::widget([
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
