<?php

use backend\modules\Product\models\ProductSource;
use kartik\form\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;


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

           <?php

           $format = <<< SCRIPT
function format(state) {
    if (!state.id) return state.text; // optgroup
    src =state.id.toLowerCase() + '.png'
    return '<img class="flag" src="' + src + '"/>' + state.text;
}
SCRIPT;
           $escape = new JsExpression("function(m) { return m; }");
           $this->registerJs($format, View::POS_HEAD);

           $form = ActiveForm::begin([
               'id' => 'product-edit',
               'action' => 'uiblock',
               'options' => ['class' => 'product-edit','enctype'=>'multipart/form-data'],

           ]);


           echo $form->field($model, 'title')->widget(Select2::classname(), [
               'name' => 'state_12',
               'data' => $data,
               'options' => ['placeholder' => 'Select a product ...'],
               'pluginOptions' => [
                   'templateResult' => new JsExpression('format'),
                   'templateSelection' => new JsExpression('format'),
                   'escapeMarkup' => $escape,
                   'allowClear' => true
               ],
           ])->label('Product');
           ?>
    <?= Html::submitButton('Block Days', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
    <?= Html::submitButton('Block Times', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value'=>'Create', 'name'=>'submit']) ?>
    <?php ActiveForm::end(); ?>


    <?php

        // $prodInfo=Product::getProdById(43); //With this method you get every information about a product with $id



        ?>
    </p>
</div>
