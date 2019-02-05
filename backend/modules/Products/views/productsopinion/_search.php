<?php



use yii\helpers\Html;

use yii\widgetsbackend\iveForm;



/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\ProductsopinionSearch */

/* @var $form yii\widgets\ActiveForm */

?>



<div class="productsopinion-search">



    <?php $form = ActiveForm::begin([

        'action' => ['index'],

        'method' => 'get',

    ]); ?>



    <?= $form->field($model, 'id') ?>



    <?= $form->field($model, 'product_id') ?>



    <?= $form->field($model, 'user_id') ?>



    <?= $form->field($model, 'rating') ?>



    <?= $form->field($model, 'comment') ?>



    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>

    </div>



    <?php ActiveForm::end(); ?>



</div>

