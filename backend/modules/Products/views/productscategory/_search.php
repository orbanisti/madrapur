<?php



use yii\helpers\Html;

use yii\widgetsbackend\iveForm;



/* @var $this yii\web\View */

/* @var $model app\modules\Products\models\ProductscategorySearch */

/* @var $form yii\widgets\ActiveForm */

?>



<div class="productscategory-search">



    <?php $form = ActiveForm::begin([

        'action' => ['index'],

        'method' => 'get',

    ]); ?>



    <?= $form->field($model, 'id') ?>



    <?= $form->field($model, 'name') ?>



    <?= $form->field($model, 'intro') ?>



    <?= $form->field($model, 'description') ?>



    <?= $form->field($model, 'status') ?>



    <?php // echo $form->field($model, 'link') ?>



    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>

    </div>



    <?php ActiveForm::end(); ?>



</div>

