
<?php
    /**
     * Created by PhpStorm.
     * User: ROG
     * Date: 2019. 02. 05.
     * Time: 20:38
     */

use backend\modules\Product\models\AddOn;
use backend\modules\Product\models\ProductAddOn;
use backend\modules\Product\models\ProductPrice;
    use common\models\User;
    use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
    use kartik\select2\Select2;

    use lo\widgets\Toggle;
    use yii\helpers\ArrayHelper;
    use yii\web\View;

    use yii\widgets\Pjax;


    //$this->params['breadcrumbs'][] = $this->title;

    $huf = Yii::$app->keyStorage->get('currency.huf-value') ? Yii::$app->keyStorage->get('currency.huf-value') : null;
    Pjax::begin(['id'=>'grid-pjax']);

?>

<!--suppress ALL -->
<style>
    .wrapper {
        overflow-y: hidden;
    }
</style>

<style>
    @media only screen and (max-width:500px){
        .content-header{
            padding: 3px 0.5rem;
        }

        .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto{
            padding-right: 1.5px;
            padding-left: 1.5px;
        }

        .container-fluid{
            padding-right: 1.5px;
            padding-left: 1.5px;
        }

        .btn.btn-flat{
            width: 45%;
        }

        .btn-info{
            width: 100%;
        }

        .kartik-sheet-style{
            display:flex;
        }

        .kv-grid-demo{
            display:flex;
        }

        .table th, .table td{
            font-size: 15px!important;
            border: none!important;
            margin: 4px 0px!important;
        }

        .panel-heading{
            text-align:center;
        }

        .panel-body > .panel-body{
            padding: 5px;
            border-bottom: 10px solid white;
        }

        .datepicker table{
            width:100%!important;
        }

        .border-secondary{
            box-shadow: 0px 0px 5px 2px #17a2b8;
        }
    }
</style>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
      <div class="card card-info ">
            <div class="card-header">
                <i class="fas fa-ticket-alt  "></i>

            </div>

            <div class="card-body">
                <div class="products-index">

                    <?php
                        if ($disableForm != 1) {
                            if ($newReservation) {

                                echo $newReservation;
                            }
                            $form = ActiveForm::begin(['id' => 'product-form','options' => ['data-pjax' => true ]]);

                            ?>


                            <?php

                            echo $form->field($model, 'title')
                                ->radioButtonGroup(ArrayHelper::map($allMyProducts, 'id', 'shortName'),
                                               ['prompt' => 'Please select a product'])->label(false);

                            ?>
                            <!-- Compiled and minified JavaScript -->


                            <?= $form->field($model, "start_date")->widget(
                                DatePicker::class, [
                                'type' => DatePicker::TYPE_COMPONENT_PREPEND
                                , 'options' => [
                                'value' => date('Y-m-d', time()),
                                'class' => 'bg-gradient-info '

                                ],
                                'pluginOptions' => [

                                    'autoclose' => true,

                                    'format' => 'yyyy-mm-dd',
                                    'startDate' => date(time()),

                                ],


                            ]); ?>









                            <?= $form->field($model, 'times')
                                ->radioButtonGroup(['prompt' => 'Please select a time']);

                            ?>

                            <div class="panel">
                                <?=Toggle::widget(
                                    [
                                        'name' => 'paid_status', // input name. Either 'name', or 'model' and 'attribute'
                                        // properties must be specified.

                                        'checked' => true,
                                        'id'=>'paid_status',

                                        'options' => [
                                            'data-on'=>'Paid',
                                            'data-off'=>'Unpaid',
                                            'data-width'=>'100px',
                                            'data-onstyle'=>'info'
                                        ],

                                        // checkbox options. More data html options [see here](http://www.bootstraptoggle.com)
                                    ]
                                );?>



                                <?=   Toggle::widget(
                                    [
                                        'name' => 'paid_currency', // input name. Either 'name', or 'model' and 'attribute' properties must be specified.
                                        'checked' => false,
                                        'options' => [
                                            'data-on'=>'EUR',
                                            'data-off'=>'HUF',
                                            'data-width'=>'100px',
                                            'data-onstyle'=>'info'
                                        ],
                                        // checkbox options. More data html options [see here](http://www.bootstraptoggle.com)
                                    ]
                                );?>
                                <?=Toggle::widget(
                                    [
                                        'name' => 'paid_method', // input name. Either 'name', or 'model' and 'attribute' properties must be specified.
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

                                <?php



                                ?>


                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4">

                                        </div>

                                    </div>
                                </div>



                            </div>


                            <div id="myTimes"></div>
                            <div id="myPrices"></div>
                            <?= Html::submitButton('Create Reservation', ['class' => 'create btn btn-block bg-aqua btn-lg btn-info prodUpdateBtn', 'disabled' => true]) ?>


                            <?php ActiveForm::end();

                            Pjax::end();



                        } else {
                            if (isset($_POST['paid_status'])) {
                                $paid_status = 'paid';

                            } else {
                                $paid_status = 'unpaid';
                            }

                            if (isset($_POST['paid_method'])) {
                                $paid_method = 'card';
                            } else {
                                $paid_method = 'cash';
                            }
                            if (isset($_POST['paid_currency'])) {
                                $paid_currency = 'EUR';
                            } else {
                                $paid_currency = 'HUF';
                            }
                            if(isset($_POST['ticketId'])){
                                $oldTicketId=$_POST['ticketId'];

                            }else{
                                $oldTicketId=null;

                            }

                            $form = ActiveForm::begin(['id' => 'product-form']);
                            $model = new ProductPrice();
                            # var_dump($myPrices);
                            echo '</br>';

                            // TODO fix this nonsense másmodelenátpushingolni egy Reservation
                            ?>
                            <?=Html::hiddenInput('paid_currency', $paid_currency);?>
                            <?=Html::hiddenInput('paid_status', $paid_status);?>
                            <?=Html::hiddenInput('paid_method', $paid_method);?>
                            <?=$oldTicketId ? Html::hiddenInput('ticketId', $oldTicketId) : null;?>


                            <?php





                            foreach ($myPrices as $i => $price) {

                                if ($paid_currency == 'HUF') {
                                    $price = ProductPrice::eurtohuf($price);
                                    $currencySymbol='Ft';
                                }else{
                                    $currencySymbol='€';
                                }



                                echo $price->name."($price->price $currencySymbol/person)" ;

                                $currentProdId = (Yii::$app->request->post('Product'))['title'];
//                                echo $form->field($model, "description[$i]")->widget(TouchSpin::class,
//                                                                                     ['options' =>
//                                                                                          [
//
//                                                                                              'placeholder' => 'Adjust ...',
//                                                                                              'data-priceid' => $price->id,
//                                                                                              'autocomplete' => 'off',
//                                                                                              'type'   => 'number'
//                                                                                          ],
//                                                                                      'pluginOptions' => [
//                                                                                          'buttonup_txt'=>'<i class="fas fa-lg bg-info fa-caret-square-up  "></i>',
//                                                                                          'buttondown_txt'=>'<i class="fas fa-lg bg-info fa-caret-square-down  "></i>',
//
//                                                                                          'max'=>'9999999'
//                                                                                      ]
//                                                                                     ]   )->label(false);

                            }
                            echo $form->field($model, 'product_id')->hiddeninput(['value' => $currentProdId])->label(false);
                            echo $form->field($model, 'booking_date')->hiddeninput(['autocomplete' => 'off', 'autocapitalize' => 'off', 'autocorrect' => 'off', 'value' => (Yii::$app->request->post('Product'))['start_date']])->label(false);
                            echo $form->field($model, 'time_name')->hiddeninput(['value' => (Yii::$app->request->post('Product'))['times']])->label(false);

                            echo $form->field($model, 'discount')->hiddeninput()->label(false);
                            ?>



                            <!-- interactive chart -->
                            <div class="card bg-info  card-outline ">
                                <div class="card-header "    data-card-widget="collapse">
                                    <h3 class="card-title">
                                        Seller Tools
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool"
                                                data-card-widget="collapse"><i class="fas fa-plus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="card-body bg-gradient-white row">
                                    <div class="col-lg-12">
                                        Custom Price
<!--                                        --><?//= TouchSpin::widget(
//                                            [   'name'=>'customPrice',
//                                                'options' =>
//                                                    [
//
//                                                        'placeholder' => 'Adjust ...',
//                                                        'data-priceid' => $price->id,
//                                                        'autocomplete' => 'off',
//                                                        'type'   => 'number',
//
//                                                    ],
//                                                'pluginOptions' => [
//                                                    'buttonup_txt'=>'<i class="fas fa-lg bg-info fa-caret-square-up  "></i>',
//                                                    'buttondown_txt'=>'<i class="fas fa-lg bg-info fa-caret-square-down  "></i>',
//
//                                                    'max'=>'9999999'
//                                                ]
//                                            ]   );
//                                        ?>

                                    </div>

                                    <div class="col-lg-8">
                                        Selling for Somebody else?
                                        <?php

                                            echo Select2::widget( [
                                                                      'name' => 'anotherSeller',
                                                                      'data' => User::getAllSellers(),
                                                                      'id' => rand(),
                                                                      'options' => ['placeholder' => 'Select a seller...'],
                                                                      'pluginOptions' => [

                                                                          'allowClear' => true
                                                                      ],
                                                                  ]);



                                        ?>
                                    </div>
                                    <div class="col-lg-4">
                                        For somebody in the past?
                                        <?php

                                            echo DatePicker::widget([
                                                                        'name' => 'sellerCustomDate',
                                                                        'type' => DatePicker::TYPE_BUTTON,
                                                                        'value' => date('Y-m-d', time()),

                                                                        'pluginOptions' => [
                                                                            'format' => 'yyyy-mm-dd',
                                                                            'autoclose'=>true
                                                                        ]
                                                                    ]);
                                        ?>
                                    </div>

                                </div>
                                <!-- /.card-body-->
                            </div>

                            <div class="card bg-info  card-outline collapsed-card">
                                <div class="card-header "    data-card-widget="collapse">
                                    <h3 class="card-title">
                                        <i class="fas fa-user-friends  "></i>
                                        Customer Details
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool"
                                                data-card-widget="collapse"><i class="fas fa-plus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="card-body bg-gradient-white">
                                    <div class="col-lg-12">

                                                <input type="text" name="customerName" id="" class="form-control"
                                                       placeholder="Customer Name"
                                                       aria-describedby="helpId">

                                                <textarea name="orderNote" id="orderNote" class="form-control"
                                                       placeholder="orderNote"
                                                          aria-describedby="helpId" form="product-form"></textarea>


                                    </div>



                                </div>
                                <!-- /.card-body-->
                            </div>
                            <!-- /.card -->

                            <div class="card bg-info  card-outline ">
                                <div class="card-header "    data-card-widget="collapse">
                                    <h3 class="card-title">
                                        Add-ons
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool"
                                                data-card-widget="collapse"><i class="fas fa-plus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="card-body bg-gradient-white">
                                    <div class="col-lg-12">
                                        <?php
                                            $addOnLinks = ProductAddOn::find()
                                                ->andFilterWhere(['=', 'prodId', $currentProdId])
                                                ->all();
                                            foreach ($addOnLinks as $i => $addOnLink) {
                                                $addOn = AddOn::findOne(['id' => $addOnLink->addOnId, 'type' => 'simple']);
                                                if ($addOn) {
                                                    $addOnPrice = $addOn->price;

                                                    if ($paid_currency == 'HUF') {
                                                        $addOnPrice = $addOn->hufPrice ? $addOn->hufPrice :
                                                            ProductPrice::eurtohufValue
                                                        ($addOnPrice);
                                                    }

                                                    echo $form->field(
                                                        $model, "Addons[{$addOn->id}]")->checkbox([
                                                        'value' => $addOnPrice,
                                                        'checked' => false,
                                                        'data-id' => $addOnLink->addOnId,
                                                        'data-add-on' => true,
                                                    ])->label("$addOn->name ($addOnPrice $paid_currency)");
                                                }
                                            }
                                        ?>

                                    </div>



                                </div>
                                <!-- /.card-body-->
                            </div>
                            <!-- /.card -->



                            <div class="col-lg-12 customPrice " >
                                <div class="box box-default box-solid ">
                                    <div class="box-header  bg-blue-gradient with-border">
                                        <h3 class="box-title"></h3>
                                        <div class="box-tools float-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">

                                                <i class="fas fa-plus-circle fa-lg text-white"></i>
                                            </button>
                                        </div>
                                        <!-- /.box-tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- /.box-body -->
                                </div>
                                <div class="col-lg-12">
                                    <div class="small-box bg-info">
                                                  <div class="inner">
                                                      <?='Total Price' . ' <strong>(' . $paid_currency . ')</strong>'?>

                                                    <p><h4><div id="total_price">0</div></h4></p>
                                                  </div>
                                                  <div class="icon">
                                                      <i class="fas fa-cart-plus  "></i>
                                                  </div>

                                                </div>


                                </div>
                            </div>



                            <?php
                            echo'<div class="col-lg-12">';
                            echo Html::submitButton('Create Reservation', ['class' => 'create btn btn-block bg-aqua btn-lg btn-info prodUpdateBtn']);
                            echo'</div>';
                            ActiveForm::end();
                        }

                        //

                    ?>
                </div>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>






<?php
    $toggledisplay = <<< SCRIPT

         function toggleshowcPrice(){
        if($('.customPrice').css('display')!='none'){
            $('.customPrice').hide();
        }
        else{
            $('.customPrice').show();
        }

    }
    
     $().ready(() => {
     
        $('.bootstrap-switch-label').on('click',toggleshowcPrice);
        $('.bootstrap-switch-handle-on').on('click',toggleshowcPrice);
      
 
 
     })



SCRIPT;


    $this->registerJs($toggledisplay, View::POS_HEAD);

?>


<script>
    var countPrices =<?=$countPrices?>;

    function myFunction(item, index) {

        $('#product-times').html($('#product-times').html() + '<label class="btn btn-outline-secondary "><input' +
            ' type="radio" id="product-times--0" name="Product[times]" value="'+item["name"]+'" data-index="0" ' +
            'autocomplete="off"> '+item["name"]+'</label>');
        $('#product-times option:eq(2)').attr('selected', 'selected');
        $('#product-times option:eq(1)').attr('selected', 'selected');

    }


    function gatherPrices() {
        var PricesObj = {}; // note this
        var i = 0;
        while (i < countPrices) {
            PricesObj[$('#productprice-description-' + i).attr('data-priceid')] = $('#productprice-description-' + i).val();
            i = i + 1
        }
        return PricesObj;
    }

    function countallPrices(){
        var counter = 0;
        var i = 0;
        while(i<countPrices){

            var howmany = $('#productprice-description-' + i).val()
            if(howmany){
                counter+=parseInt(howmany)  ;
            }
            i+=1;

        }
        return counter;

    }


    $().ready(() => {
        if(countPrices){
            validCheck();
        }
        $('#product-times').change(function () {
        $('#product-times').val($('[name="Product[times]"]:checked').val())
            var timeVal = $('#product-times').val();

            if (timeVal!='') {
                $('.create').prop("disabled", false);
            }
            else {
                $('.create').prop("disabled", true);
            }
        });
    function getTimes(){
        $('#product-title').val($('[name="Product[title]"]:checked').val())
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/Reservations/reservations/gettimes' ?>',
            type: 'post',
            data: {
                id:   $('#product-title').val(),
                date: $('#product-start_date').val(),
            },
            success: function (data) {
                console.log(data.search);

                mytimes = data.search
                $('#myTimes').html('');
                $('#product-times').html('')
                mytimes.forEach(myFunction)
            }


        });
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/Reservations/reservations/getprices' ?>',
            type: 'post',
            data: {
                id:  $('#product-title').val(),

            },
            success: function (data) {
                console.log(data.search);
                mytimes = data.search
                $('#myPrices').html(mytimes);
            }
        });
    }

    $('#product-title').change(function () {
        getTimes();

    });
    $('#product-start_date').change(function () {
        getTimes();

    });


    });



    <?php

    $currentProdId = (Yii::$app->request->post('Product'))['title'];
    if (!$currentProdId) {
        $currentProdId = 0;
    }
    ?>

    function gatherPrices() {
        var PricesObj = {}; // note this
        var i = 0;
        while (i < countPrices) {
            PricesObj[$('#productprice-description-' + i).attr('data-priceid')] = $('#productprice-description-' + i).val();
            i = i + 1
        }

        return PricesObj;

    }


    function validCheck(){

        if(countallPrices()==0){
            $('.create').prop("disabled", true);
        }
        else{
            $('.create').prop("disabled", false);
        }


    }

    function gatherAddOns() {
        var addOnsObj = {};
        var countAddOns = $("input[data-add-on]");

        countAddOns.each(function(idx, element) {
            if (element.checked) {
                addOnsObj[$(element).attr("data-id")] = element.value;
            }
        });

        console.log(addOnsObj);

        return addOnsObj;
    }

    var Total = 0;
    $('#product-form').change(function () {

        if(countPrices){
            validCheck();
        }


        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/Reservations/reservations/calcprice' ?>',
            type: 'post',
            data: {
                prices: gatherPrices(),
                productId: $('#product-title').val(),
                date: $('#product-start_date').val(),
                time: $('#product-times').val(),
                prodid: <?=(Yii::$app->request->post('Product'))['title'] ? (Yii::$app->request->post('Product'))['title'] : 999 ?>,
                currency: '<?=isset($paid_currency) ? $paid_currency : 0 ?>',
                customPrice:$('input[name=customPrice]').val(),
                addOns: gatherAddOns(),
            },
            success: function (data) {


                mytimes = data.search;

                if(data.customPrice){

                    $('#total_price').html(data.customPrice);
                    mytimes = data.customPrice
                }
                $('#total_price').html( $('#total_price').html()+mytimes);
                $('#total_price').html(mytimes);

                // To be continued
                $('#productprice-discount').val(mytimes);
                if (data.response == 'places') {
                    $('#myPrices').html(mytimes);
                }


            }
        });
    });

    $().ready(() => {
        $('#product-start_date'
    ).attr('autocomplete', 'off');
    })
    ;


</script>

<style>
    .btn-group{
        display:block !important;
    }
    #product-form {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none;
        /* Non-prefixed version, currently
                                         supported by Chrome and Opera */
    }
</style>


