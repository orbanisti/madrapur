<?php
    \backend\assets\BackendAsset::register($this);
    \frontend\assets\FrontendAsset::register($this);
?>
<style>
    #total_price::before{
        content: '€ ';

    }

</style>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <?php
                    \yii\widgets\Pjax::begin(['id' => 'main-book'])
                ?>

                <?php

                    use backend\modules\Product\models\AddOn;
                    use backend\modules\Product\models\Product;
                    use backend\modules\Product\models\ProductAddOn;
                    use backend\modules\Product\models\ProductPrice;
                    use backend\modules\Reservations\models\Reservations;
                    use kartik\date\DatePicker;
                    use kartik\form\ActiveForm;
                    use kartik\helpers\Html;
                    use kartik\icons\Icon;
                    use kartik\widgets\DepDrop;
                    use kartik\widgets\TouchSpin;
                    use yii\helpers\Url;

                    $form = ActiveForm::begin(['id' => 'remote-form','options' => ['data-pjax' => true ]]);

                    $currrentProductId = Yii::$app->request->get('id');

                    if ($currrentProductId) {
                        $currentProduct = Product::findOne($currrentProductId);

                        $query = ProductPrice::find()->andFilterWhere(['=', 'product_id', $currrentProductId]);
                        $myPrices = $query->all();
                        $countprices = $query->count();
                        foreach ($myPrices as $i => $price) {

                            echo $price->name;
                            $model = new Reservations();

                            $currentProdId = Yii::$app->request->get('id');
                            echo $form->field($model, "data[prices][$i]")->widget(
                                TouchSpin::class,
                                [
                                    'options' =>
                                        [

                                            'placeholder' => 'Adjust ...',
                                            'data-priceid' => $price->id,
                                            'autocomplete' => 'off',
                                            'type' => 'number'
                                        ],
                                    'pluginOptions' => [
                                        'buttonup_txt' => Icon::show(
                                            'caret-square-up', [
                                            'class' => 'fa-lg
                                                    bg-info', 'framework'
                                            => Icon::FAS
                                        ]
                                        ),
                                        'buttondown_txt' => Icon::show(
                                            'caret-square-down',
                                            [
                                                'class' => 'fa-lg  bg-info', 'framework'
                                            => Icon::FAS
                                            ]
                                        ),

                                        'max' => '9999999'
                                    ]
                                ]
                            )->label(false);
                        }
                    }
                ?>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-check">


                                <?php
                                    \frontend\assets\MdbCheckboxAsset::register($this);
                                    $addOnLinks = ProductAddOn::find()
                                        ->andFilterWhere(['=', 'prodId', $currentProdId])
                                        ->all();
                                    foreach ($addOnLinks as $i => $addOnLink) {
                                        $addOn = AddOn::findOne(['id' => $addOnLink->addOnId, 'type' => 'simple']);
                                        if ($addOn) {
                                            $addOnPrice = $addOn->price;

                                            echo "<input type=\"checkbox\"  data-add-on='true' data-id='$addOnLink->addOnId' value='$addOnPrice' 
 name=\"Reservations[data][addons][$i]\" id=\"Reservations[data][addons][$i]\" 
class=\"form-check-input\" id=\"materialUnchecked\">
                                     <label class=\"form-check-label\" 
                                     for=\"Reservations[data][addons][$i]\">$addOn->name ( € $addOnPrice )</label>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                    </div>



                <script>
                    function gatherAddOns() {
                        var addOnsObj = {};
                        var countAddOns = $("input[data-add-on]");

                        countAddOns.each(function (idx, element) {
                            if (element.checked) {
                                addOnsObj[$(element).attr("data-id")] = element.value;
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
                                prodid: <?=Yii::$app->request->get('id')?>,
                                currency: '<?=isset($paid_currency) ? $paid_currency : 0 ?>',
                                customPrice: $('input[name=customPrice]').val(),
                                addOns: gatherAddOns(),
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
                        <div class="col-lg-3">
                            <?php
                                \frontend\assets\FontAwesome4Asset::register($this);

                                echo DatePicker::widget([
                                                            'name' => 'Reservations[bookingDate]',
                                                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                            'value' => date('Y-m-d',time()),
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'yyyy-mm-dd'
                                                            ],
                                                            'id'=>'cat-id'

                                                        ]);

                            ?>
                        </div>
                        <div class="col-lg-3">
                            <?php
                                echo $form->field($model, 'booking_start')->widget(DepDrop::classname(), [
                                    'options'=>['id'=>'subcat-id'],
                                    'pluginOptions'=>[
                                        'depends'=>['cat-id'],
                                        'placeholder'=>'Select...',

                                        'url'=>Url::to(['gettimesarray']).'?id='.$currrentProductId,

                                        'initialize' => true,

                                    ]
                                ])->label(false);
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

                            <p>Total Price</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cart-plus  "></i>
                        </div>
                    </div>


                </div>

                <div class="col-lg-12">
                    <?php

                        echo Html::submitButton('create',['class'=>'btn btn-info btn-large']);
                        ActiveForm::end();

                    ?>
                </div>

                <?php
                    \yii\widgets\Pjax::end();
                ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>