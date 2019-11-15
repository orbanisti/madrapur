<?php

    use backend\modules\Product\models\ProductPrice;

    \backend\assets\BackendAsset::register($this);
    \frontend\assets\FrontendAsset::register($this);
?>

Congrats!
<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h4>Subtotal</h4>
                <?php
                    $currentProductId=Yii::$app->request->get('id');
                    $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id='
                                                                      . $currentProductId);

                    $myprices = $query->all();
                    foreach ($myprices as $index=>$price)
                    {
                        if($model->data["prices"][$index]){
                            echo $price->name."(€ $price->price/person)".' x '.$model->data["prices"][$index]."= €"
                                .$price->price*$model->data["prices"][$index].'<br/>';

                        }

                    }




                ?>
               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>