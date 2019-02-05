<?php



use yii\helpers\Html;

use yii\widgets\ActiveForm;

use kartik\datecontrol\DateControl;

use backend\modules\Products\models\Products;

use kartik\select2\Select2;



/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Blockouts */

/* @var $form yii\widgets\ActiveForm */



?>



<div class="blockouts-form">



    <?php $form = ActiveForm::begin(); //Yii::$app->extra->e($model->dates); ?>



    <?php /*$form->field($model, 'start_date')->widget(DateControl::classname(), [

            'ajaxConversion'=>false,

            'autoWidget'=>true,

            'displayFormat' => 'php:Y-m-d',

            'type'=>  DateControl::FORMAT_DATE,

            'options' => [

                'pluginOptions' => [

                    'autoclose' => true

                ]

            ]

        ]); ?>

    

    <?php $form->field($model, 'end_date')->widget(DateControl::classname(), [

            'ajaxConversion'=>false,

            'autoWidget'=>true,

            'displayFormat' => 'php:Y-m-d',

            'type'=>  DateControl::FORMAT_DATE,

            'options' => [

                'pluginOptions' => [

                    'autoclose' => true

                ]

            ]

        ]);*/ ?>

    

    <?= $form->field($model, 'dates')->widget(DateControl::classname(), [

            'ajaxConversion'=>false,

            'autoWidget'=>true,

            'displayFormat' => 'php:Y-m-d',

            'type'=>  DateControl::FORMAT_DATE,

            'options' => [

                'pluginOptions' => [

                    //'autoclose' => true,

                    'multidate' => true,

                    'multidateSeparator' => ',',

                ]

            ]

        ]); ?>



    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [

                'data' => Products::getUserproducts(), //ArrayHelper::map(Users::find()->where('id != :id', ['id'=>Yii::$app->user->id])->all(), 'id', 'username'),

                'language' => 'hu',

                'options' => ['placeholder' => Yii::t('app','Termék...')],

                'pluginOptions' => [

                    'allowClear' => true,

                ],

            ]); ?>



    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Létrehozás') : Yii::t('app', 'Módosítás'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>



    <?php ActiveForm::end(); ?>



</div>



<script>

    $( document ).ready(function() {

        $('#blockouts-dates-disp').val('<?= $model->dates ?>');

    });

</script>