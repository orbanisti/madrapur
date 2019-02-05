<?php



use yii\helpers\Html;
backend\
use yii\widgets\ActiveForm;
backend\
use yii\helpers\ArrayHelper;

use app\modulesbackend\rs\models\Users;

use kartik\select2\Select2;

use app\modules\Users\models\Userpartners;



/* @var $this yii\web\View */

/* @var $model app\modules\Users\models\Userpartners */

/* @var $form yii\widgets\ActiveForm */

?>



<div class="userpartners-form">



    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'partner_id')->widget(Select2::classname(), [

                'data' => ArrayHelper::map(Users::find()->where('id != :id', ['id'=>Yii::$app->user->id])->all(), 'id', 'username'),

                'language' => Yii::$app->language,

                'options' => ['placeholder' => 'Partner...'],

                'pluginOptions' => [

                    'allowClear' => false,

                ],

    ]); ?>

    

    <?= $form->field($model, 'rights')->dropDownList(Userpartners::rights()); ?>



    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Mentés'), ['class' => 'btn btn-primary']) ?>

    </div>



    <?php ActiveForm::end(); ?>



</div>

