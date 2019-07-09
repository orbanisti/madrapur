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


        // $prodInfo=Product::getProdById(43); //With this method you get every information about a product with $id



        ?>
    </p>
</div>
