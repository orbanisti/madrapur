<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 *
 * @var $this yii\web\View
 * @var $model common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */

?>

<?php
\yii\widgets\Pjax::begin();
$form = ActiveForm::begin(['options' => [
    'data-pjax'=>true
    ]

]) ?>

<?=$form->field($seomodel, 'mainKeyword')->textInput(['maxlength' => true]) ?>
<?=$form->field($seomodel, 'meta+name+description')->textarea(['maxlength' => true])->label('Meta Description') ?>
<?=$form->field($seomodel, 'postId')->hiddeninput(['value' => $model->id])->label(false);?>
<?=$form->field($seomodel, 'postType')->hiddeninput(['value' =>'article'])->label(false);?>

<?=$form->field($seomodel, 'source')->hiddeninput(['value' =>'madrapur'])->label(false);?>

<?php
    echo Html::submitButton($seomodel->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
                            [
                                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                            ]) ?>


<?php ActiveForm::end();
    \yii\widgets\Pjax::end();

?>
