<?phpbackend\backend\backend\

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\Users\Module as Usermodule;
use app\models\Shopcurrency;
use app\modules\Products\models\Products;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Usermodule::status()); ?>

    <?= $form->field($model, 'type')->dropDownList(Usermodule::type()); ?>

    <?= $form->field($model, 'payment_in_advance')->dropDownList(Usermodule::paymentad()); ?>

    <?php //$form->field($model, 'dividend')->textInput() ?>

    <?= $form->field($model, 'commission')->textInput() ?>

    <?= $form->field($model, 'commission_type')->dropDownList(Products::commissiontypes())->label(false); ?>

    <?= $form->field($model, 'comment')->textarea() ?>

    <?= $form->field($model, 'contract')->dropDownList(Usermodule::contract()); ?>

    <h4>Eddigi rendelések alapján a jutalék összege</h4>
    <?= Shopcurrency::priceFormat($model->dividendprice); ?>
    <br/><br/>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Mentés'), ['class' => 'btn btn-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

