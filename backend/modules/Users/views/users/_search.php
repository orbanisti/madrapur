<?php



use yii\helpers\Html;

use yii\widgetsbackend\iveForm;



/* @var $this yii\web\View */

/* @var $model app\modules\Users\models\UsersSearch */

/* @var $form yii\widgets\ActiveForm */

?>



<div class="users-search">



    <?php $form = ActiveForm::begin([

        'action' => ['index'],

        'method' => 'get',

    ]); ?>



    <?= $form->field($model, 'id') ?>



    <?= $form->field($model, 'email') ?>



    <?= $form->field($model, 'username') ?>



    <?= $form->field($model, 'password') ?>



    <?= $form->field($model, 'regdate') ?>



    <?php // echo $form->field($model, 'status') ?>



    <?php // echo $form->field($model, 'hashcode') ?>



    <?php // echo $form->field($model, 'rights') ?>



    <?php // echo $form->field($model, 'type') ?>



    <?php // echo $form->field($model, 'referrer') ?>



    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>

    </div>



    <?php ActiveForm::end(); ?>



</div>

