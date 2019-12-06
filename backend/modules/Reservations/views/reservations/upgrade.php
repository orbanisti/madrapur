<?php

    use backend\modules\Product\models\AddOn;
    use backend\modules\Product\models\Product;
    use backend\modules\Product\models\ProductAddOn;
    use backend\modules\Product\models\ProductPrice;
    use backend\modules\Product\models\ProductTime;
    use backend\modules\Reservations\models\Reservations;
    use kartik\detail\DetailView;
    use kartik\icons\Icon;
    use kartik\widgets\ActiveForm;
    use kartik\widgets\TouchSpin;
    use lo\widgets\Toggle;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use \backend\modules\Tickets\models\TicketSearchModel;
    \frontend\assets\FontAwesome4Asset::register($this);
?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->

                <div class="card card-info">
                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                            Upgrading booking #<?=$reservation->id?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php
                            $settings = [
                                'model' => $reservation,
                                'condensed' => true,
                                'hover' => true,
                                'mode' => DetailView::MODE_VIEW,



                                'attributes' => [
                                    [
                                        'attribute' => 'ticketId',
                                        'type' => DetailView::INPUT_TEXTAREA,
                                        'format' => 'html',
                                        'value' => Html::a(
                                            $reservation->ticketId, [
                                                                      '/Tickets/tickets/view-ticket',
                                                                      'id' => $model->ticketId,
                                                                      'blockId' => $model->ticketId,
                                                                  ]
                                        )
                                    ],

                                    [
                                        'attribute' => 'billing_first_name',
                                        'label' => 'Name',

                                        'value'=> $reservation->billing_first_name.' '.$reservation->billing_last_name

                                    ],

                                    [
                                        'attribute' => 'productId',
                                        'value' => (Product::findOne($reservation->productId))->title,
                                        'label' => 'Product'
                                    ],

                                    [
                                        'attribute' => 'booking_start',
                                        'value' => substr($reservation->booking_start, 0, -3),

                                    ],
                                    [
                                        'attribute' => 'allPersons',
                                        'format' => ['raw'],
                                        'value'=>$reservation->allPersons.' '.$addonIcons
                                    ],

                                ]
                            ];

                            //                    $settings['attributes'][]=['attribute'=>'status'];
                            //
                            //                    foreach(json_decode($model->data) as  $key=>$attribute){
                            //                        echo $key.json_encode($attribute);
                            //                    }

                            echo DetailView::widget($settings);


                        ?>



                    </div>
                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-ticket-alt" aria-hidden="true"></i>
                            <?= TicketSearchModel::userNextTicketId(); ?>

                        </div>
                    </div>
                    <div class="card-body">
                        <?php


                            $form = ActiveForm::begin(['id' => 'remote-form','options' => ['data-pjax' => true ]]);

                            $currrentProductId = $currentProdId;

                            if ($currrentProductId) {
                                $currentProduct = Product::findOne($currrentProductId);

                                $query = ProductPrice::find()->andFilterWhere(['=', 'product_id', $currrentProductId]);
                                $myPrices = $query->all();
                                $countprices = $query->count();
                                echo Html::hiddenInput('Reservations', 2);


                            }

                        ?>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="form-check">


                              <div class="card">
                                        <div class="card-body">
                                            <?php

                                                \frontend\assets\MdbCheckboxAsset::register($this);
                                                $addOnLinks = ProductAddOn::find()
                                                    ->andFilterWhere(['=', 'prodId', $currentProdId])
                                                    ->all();
                                                foreach ($addOnLinks as $i => $addOnLink) {

                                                    $addOn = AddOn::findOne(['id' => $addOnLink->addOnId, 'type' => 'simple']);
                                                    if ($addOn) {
                                                        if(!in_array($addOn->id,$alreadyAddon)){
                                                            $addOnPrice = $addOn->price;
                                                            $paid_currency=Yii::$app->request->get('currency');
                                                            if ($paid_currency == 'HUF') {
                                                                $addOnPrice = $addOn->hufPrice ? $addOn->hufPrice :
                                                                    ProductPrice::eurtohufValue
                                                                    ($addOnPrice);
                                                                echo Html::hiddenInput('currency', $paid_currency);
                                                            }else{

                                                                $paid_currency='EUR';
                                                                echo Html::hiddenInput('currency', $paid_currency);
                                                            }
                                                            echo "<input type=\"checkbox\"  data-add-on='true' data-id='$addOnLink->addOnId'  
data-price='$addOnPrice' value='$addOnPrice'
 name=\"Reservations[data][addons][$addOnLink->addOnId]\" id=\"Reservations[data][addons][$addOnLink->addOnId]\" 
class=\"form-check-input\" id=\"materialUnchecked\">
                                     <label class=\"form-check-label\" 
                                     for=\"Reservations[data][addons][$addOnLink->addOnId]\">$addOn->name ( $addOnPrice $paid_currency /person)</label>";
                                                        }

                                                    }

                                                }
                                            ?>
                                        </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-body">
                                                <?php


                                                    echo Toggle::widget(
                                                        [
                                                            'name' => 'card', // input name. Either 'name', or 'model' and 'attribute'
                                                            // properties must be specified.
                                                            'checked' => false,
                                                            'id'=>'currency_selector',
                                                            'options' => [
                                                                'data-on'=>'Card',
                                                                'data-off'=>'Cash',
                                                                'data-width'=>'100px',
                                                                'data-onstyle'=>'info'
                                                            ],
                                                            // checkbox options. More data html options [see here](http://www.bootstraptoggle.com)
                                                        ]
                                                    );?>
                                            </div>
                                        </div>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>





                <script>
                    function gatherAddOns() {
                        var addOnsObj = {};
                        var countAddOns = $("input[data-add-on]");

                        countAddOns.each(function (idx, element) {
                            if (element.checked) {
                                addOnsObj[$(element).attr("data-id")] = $(element).attr("data-price");
                            }
                        });

                        console.log(addOnsObj);

                        return addOnsObj;
                    }

                    function gatherPrices() {
                        var countPrices = "<?=$countprices?>";
                        var PricesObj = {}; // note this
                        var i = 0;
                        while (i < countPrices) {
                            PricesObj[$('#reservations-data-prices-' + i).attr('data-priceid')] = $
                            ('#reservations-data-prices-' + i).val();
                            i = i + 1
                        }

                        return PricesObj;

                    }

                    $('#remote-form').change(function () {
                        $.ajax({
                            url: '<?php echo Yii::$app->request->baseUrl . '/Reservations/reservations/calcpriceremote'
                                ?>',
                            type: 'post',
                            data: {
                                prices: gatherPrices(),
                                productId: $('#product-title').val(),
                                date: $('#product-start_date').val(),
                                time: $('#product-times').val(),
                                prodid: <?=$currentProdId?>,
                                currency: '<?=isset($paid_currency) ? $paid_currency : 0 ?>',
                                customPrice: $('input[name=customPrice]').val(),
                                addOns: gatherAddOns(),
                                reservationId:'<?=Yii::$app->request->get("id")?>'
                            },
                            success: function (data) {


                                mytimes = data.search;


                                $('#total_price').html($('#total_price').html() + mytimes);
                                $('#total_price').html(mytimes);

                                // To be continued
                                $('#productprice-discount').val(mytimes);
                                if (data.response == 'places') {
                                    $('#myPrices').html(mytimes);
                                }


                            }
                        });
                    });


                </script>

                <script>


                </script>
                <div class="col-lg-12">
                    <div class="row">

                            <?php



                            ?>
                        </div>

                    </div>





                </div>
                <div class="col-lg-12">


                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                <div id="total_price">0</div>
                            </h3>

                            <p>Total Price (<?php
                                    $paid_currency=Yii::$app->request->get('currency');
                                    if ($paid_currency != 'HUF') {
                                        $paid_currency='EUR';
                                    }
                                    echo $paid_currency?>)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cart-plus  "></i>
                        </div>
                    </div>


                </div>

                <div class="col-lg-12">
                    <?php

                        echo Html::submitButton('Upgrade booking',['class'=>'btn btn-info btn-large','style'=>"width:100%"]);
                        ActiveForm::end();

                    ?>
                </div>






        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>