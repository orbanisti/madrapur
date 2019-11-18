<?php

    use backend\modules\Payment\controllers\PaymentController;
    use backend\modules\Product\models\AddOn;
    use backend\modules\Product\models\ProductAddOn;
    use backend\modules\Product\models\ProductPrice;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;

    \backend\assets\BackendAsset::register($this);
    \frontend\assets\FrontendAsset::register($this);
?>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-body">
               Hey <?=$model->billing_first_name?> Please Wait to be redirected to payment page.
                <?php
                    $paidMethod=$model->paidMethod;
                    if($paidMethod=='Paypal'){
                        $paypalId= Yii::$app->keyStorage->get('paypal.email');
                        $paypalURL = 'https://sandbox.paypal.com/cgi-bin/webscr';
                        $itemName=Yii::$app->request->post('itemname');
                     ?>
                        <form id="payment-form" action="<?=$paypalURL?>" method="post">
                            <input type="hidden" name="business" value="<?= $paypalId; ?>">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="item_name" value="<?=$itemName?>">
                            <input type="hidden" name="item_number" value="1">
                            <input type="hidden" name="amount" value="<?=$model->booking_cost?>">
                            <input type="hidden" name="currency_code" value="<?=$model->order_currency?>">
                            <input type='hidden' name='cancel_return' value='https://frontend.modulus.hu'>
                            <input type='hidden' name='return' value='https://frontend.modulus.hu//Reservations/reservations/success?id=<?=$model->id?>'>
                            <?=Html::submitButton('Finish Order');?>



                        </form>
                        <script>


                            $().ready(() => {
                                $("#payment-form").submit();

                            });
                        </script>






                        <?php

                    }elseif($paidMethod=='Simplepay'){
                        $ids[]=$model->id;

                        echo PaymentController::actionPay($ids);
                    }

                ?>
            </div>


            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>