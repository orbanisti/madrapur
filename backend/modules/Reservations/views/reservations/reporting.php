<?php

    use backend\modules\Product\models\ProductSource;

    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use kartik\icons\Icon;

?>

<div class="box box-widget widget-user">
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

    <div class="box-header bg-aqua-gradient">
        <!-- /.widget-user-image -->

        <h3 class="widget-user-username">Reporting Center</h3>
        <h5 class="widget-user-desc"><?=$today?> </h5>

    </div>
    <ul class="nav nav-stacked">
        <?php
            foreach ($userList as $userblock){
                echo $userblock;
            }

        ?>

    </ul>


</div>
