<?phpbackend\backend\backend\backend\backend\





use yii\helpers\Html;


use yii\widgets\ActiveForm;


use kartik\rating\StarRating;


use yii\helpers\ArrayHelper;


use app\modules\Order\models\Order;


use app\modules\Order\models\Orderedproducts;


use app\modules\Products\models\Productsopinion;





/* @var $this yii\web\View */


/* @var $model app\modules\Products\models\Productsopinion */


/* @var $form yii\widgets\ActiveForm */


?>





<div class="productsopinion-form">





    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>





    <?php





    $orders=ArrayHelper::map(Order::find()->where('customer_id='.Yii::$app->user->id)->select('order_id,order_id')->asArray()->all(),'order_id','order_id');


    $orderedprods=ArrayHelper::map(Orderedproducts::find()->where(['IN', 'order_id', $orders])->select('product_id,product_id')->asArray()->all(),'product_id','product_id');





    $product=\app\modules\Products\models\Products::findOne($model->product_id);





    $ordercount=array_count_values($orderedprods);





    $opinioncount=Productsopinion::find()->where(['product_id'=>$model->product_id,'user_id'=>Yii::$app->user->id])->count();





    if(Yii::$app->user->isGuest) { echo '<h2>'.Yii::t('app', 'Vélemény íráshoz, be kell jelentkezned!').'</h2>'; }


    elseif(/*!in_array($model->product_id, $orderedprods)*/ (isset($ordercount[$model->product_id]) && $ordercount[$model->product_id]>$opinioncount) || $product->user_id==Yii::$app->user->id) { echo '<h2>'.Yii::t('app', 'Előbb vásárolnod kell a termékből!').'</h2>'; /*echo '<h2>'.Yii::t('app', 'Még nem vásároltál ebből a termékből!').'</h2>';*/ }


    else {


    ?>





    <h2><?= Html::encode($this->title) ?></h2>





    <?php $form = ActiveForm::begin([


            'id' => 'opinion-form',


        ]); ?>





    <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>





    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>





    <?= $form->field($model, 'rating')->widget(StarRating::classname(), [


        'pluginOptions' => [


            'min' => 0,


            'max' => 5,


            'step' => 0.5,


            'showClear' => false,


            'showCaption' => false,


            'filledStar' => '<i class="price-text-color fa fa-star"></i>',


            'emptyStar' => '<i class="fa fa-star"></i>',


        ]


    ]); ?>





    <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>





    <div class="form-group">


        <?= Html::submitButton(Yii::t('app', 'Küldés'), ['class' => 'btn btn-primary']) ?>


    </div>





    <?php ActiveForm::end(); ?>





<?php


$srcipt = <<< JS


$('form#opinion-form').on('beforeSubmit', function(e)


{


    var \$form = $(this);


    $.post(


        \$form.attr("action"), //serialize Yii2 form


        \$form.serialize()


    )


        .done(function(result) {


        if (typeof(result.succes) != "undefined" || result.succes != null) {


            if(result.succes == 1)


            {


                $('#myModal').modal('hide');


                $("#opinions-slider").html(result.content);


                $("#productp-ratings").html(result.count);


                $("#product-ratings-count-top").html(result.count);


                $("#product-ratings-count").html(result.count);


                $("#product-ratings-average").html(result.average);


                $('#rating-average').rating('update', result.average);


                $('#rating-average-top').rating('update', result.average);


            } else {


                $('#myModal').modal('hide');


            }


        }


        }).fail(function()


        {


            console.log("server error");


        });


    return false;


});





JS;


$this->registerJs($srcipt);





    }


?>


</div>


