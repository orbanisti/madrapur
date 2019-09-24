<?php

    use backend\modules\Product\models\ProductSource;

    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use kartik\icons\Icon;

?>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table  "></i>
                    Reporting Center <?=$today?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
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



                        <?php
                            foreach ($userList as $userblock){
                                echo $userblock;
                            }

                        ?>




                </div>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>