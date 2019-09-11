<?php

use backend\modules\Product\models\ProductSource;

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

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

    <div class="box-header box-primary">
        <h3 class="box-title">Product Manager</h3>
    </div>
    <?php
    $gridColumns = [

        'id' ,
        'title' ,
        'capacity' ,
        'currency' ,
        [
            'class' => 'kartik\grid\ActionColumn' ,
            'visible' => Yii::$app->user->can('administrator') ,

            'template' => '{update} {delete}' ,
            'buttons' => [
                'delete' => function ($url , $model , $key) {

                    return Html::a('<span class="fa fa-lg fa-trash"></span>' ,
                        Url::to(['product/admin' ,
                            'id' => $model->id ,
                            'action' => 'delete']) ,
                        [
                            'title' => Yii::t('app' , 'Delete') ,
                            'data-pjax' => '1' ,
                            'data' => [
                                'method' => 'post' ,
                                'confirm' => Yii::t('app' , 'Are you sure you want to delete?') ,
                                'pjax' => 1 ,] ,
                        ]
                    );

                } ,
                'update' => function ($url , $model , $key) {

                    return Html::a('<span class="fa fa-lg fa-pencil"></span>' ,
                        Url::to(['product/update' ,
                            'id' => $model->id]) ,
                        [
                            'title' => Yii::t('app' , 'Delete') ,
                            'data-pjax' => '1' ,
                            'data' => [
                                'method' => 'post' ,
                                'pjax' => 1 ,] ,
                        ]
                    );

                } ,


            ]
        ] ,

//        ['attribute'=>'isDeleted','visible'=>Yii::$app->user->can('administrator')]


    ];

    echo GridView::widget([

        'dataProvider' => $dataProvider ,
        'columns' => $gridColumns ,
        'layout' => '{items}{pager}'
    ]);
    // $prodInfo=Product::getProdById(43); //With this method you get every information about a product with $id

//        $response = $client->yell($selectedDate,$currentProduct);
//        echo $response;
//

    ?>
    </p>

</div>
