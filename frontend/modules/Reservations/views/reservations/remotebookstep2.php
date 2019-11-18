<?php

    use backend\modules\Product\models\AddOn;
    use backend\modules\Product\models\ProductAddOn;
    use backend\modules\Product\models\ProductPrice;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;

    \backend\assets\BackendAsset::register($this);
    \frontend\assets\FrontendAsset::register($this);
?>

Congrats!
<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5>Subtotal</h5>
                <?php
                    $currentProductId=Yii::$app->request->get('id');
                    $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id='
                                                                      . $currentProductId);
                    $allPersons=0;
                    $myprices = $query->all();
                    $totalPrice=0;
                    $itemname='Booking for '.$model->bookingDate.' '.$model->booking_start.'(';

                    foreach ($myprices as $index=>$price)
                    {
                        if(isset($model->data['prices'])&&$model->data["prices"][$index]){
                            echo $price->name."(€ $price->price/person)".' x '.$model->data["prices"][$index]."= €"
                                .$price->price*$model->data["prices"][$index].'<br/>';
                            $allPersons+=$model->data["prices"][$index];
                            $totalPrice+=$price->price*$model->data["prices"][$index];
                            $itemname.=$price->name.' x '.$model->data["prices"][$index].', ';


                        }
                    }


                    $addOnLinks = ProductAddOn::find()
                        ->andFilterWhere(['=', 'prodId', $currentProductId])
                        ->all();
                    foreach ($addOnLinks as $i => $addOnLink) {
                        $addOn = AddOn::findOne(['id' => $addOnLink->addOnId, 'type' => 'simple']);
                        if ($addOn) {
                            if(isset($model->data["addons"])){
                                if(isset($model->data['addons'][$i]) &&$model->data['addons'][$i]==$addOn->price){
                                    echo $addOn->name.' x '.$allPersons.'= €'.$addOn->price*$allPersons.', ';
                                    $totalPrice+=$addOn->price*$allPersons;
                                    $itemname.=$addOn->name.' x '.$allPersons.'';
                                }

                            }


                        }
                    }
                    $itemname.=')';

                ?>

                <h5>Total Price: € <?=$totalPrice?></h5>

                <div class="card ">

                    <div class="card-body">
                        <?php

                            $form = ActiveForm::begin(['id' => 'remote-form-step2','options' => ['data-pjax' => true
                            ]]);
                            echo $form->field($model, 'data')->hiddeninput(['value' =>json_encode($model->data)])->label
                            (false);
                            echo $form->field($model, 'bookingDate')->hiddeninput(['value' =>$model->bookingDate])
                                ->label
                            (false);
                            echo $form->field($model, 'booking_start')->hiddeninput(['value' =>$model->bookingDate.' '.$model->booking_start])
                                ->label
                                (false);
                            echo $form->field($model, 'productId')->hiddeninput(['value' =>$model->productId])
                                ->label
                                (false);
                            echo $form->field($model, 'allPersons')->hiddeninput(['value' =>$allPersons])
                                ->label
                                (false);
                            echo $form->field($model, 'booking_cost')->hiddeninput(['value' =>$totalPrice])
                                ->label
                                (false);
                            echo $form->field($model, 'order_currency')->hiddeninput(['value' =>'EUR'])
                                ->label
                                (false);
                            echo $form->field($model, 'status')->hiddeninput(['value' =>'unpaid'])
                                ->label
                                (false);
                            echo Html::hiddenInput('itemname', $itemname);?>


                        <div class="container-fluid">
                            <form>
                                <div class="form-group row">

                                    <div class="col-lg-6">
                                      <?= $form->field($model,'billing_first_name')->textInput();?>
                                    </div>
                                    <div class="col-lg-6">
                                      <?= $form->field($model,'billing_last_name')->textInput();?>
                                    </div>
                                    <div class="col-lg-6">
                                      <?= $form->field($model,'billing_phone')->textInput();?>
                                    </div>
                                    <div class="col-lg-6">
                                      <?= $form->field($model,'billing_email')->textInput();?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?= $form->field($model,'paidMethod')->radioList(['Paypal'=>'Paypal','Simplepay'=>'Simplepay']);?>
                                    </div>

                                    <?=Html::submitButton('Finish Order',['class'=>'btn btn-info btn-large']);?>
                                </div>

                            </form>
                        </div>
                        <?php
                            ActiveForm::end();
                        ?>
<!--                       end of container-->
                    </div>
                </div>




               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>