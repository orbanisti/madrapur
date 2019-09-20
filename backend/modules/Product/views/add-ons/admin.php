<?php

use backend\modules\Product\models\ProductSource;

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

?>

<div class="product-default-index">
    <?php

    ?>

    <div class="box-header box-primary">
        <h3 class="box-title">Product Manager</h3>
    </div>
    <?php
    $gridColumns = [

        'id' ,
        'prodId' ,
        'name' ,
        'icon' ,


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
