<?php

    use dosamigos\ckeditor\CKEditor;
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

$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]) ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?php

echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you leave this field empty, the slug will be generated automatically'))
    ->textInput([
        'maxlength' => true
    ]) ?>

<?php

echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map($categories, 'id', 'title'),
    [
        'prompt' => ''
    ]) ?>

<?php

echo $form->field($model, 'body')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'full'
]) ?>

<?php

echo $form->field($model, 'thumbnail')->widget(Upload::class,
    [
        'url' => [
            '/file/storage/upload'
        ],
        'maxFileSize' => 5000000, // 5 MiB
    ]);
?>

<?php

echo $form->field($model, 'attachments')->widget(Upload::class,
    [
        'url' => [
            '/file/storage/upload'
        ],
        'sortable' => true,
        'maxFileSize' => 10000000, // 10 MiB
        'maxNumberOfFiles' => 10,
    ]);
?>

<?php echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'status')->checkbox() ?>

<?php

echo $form->field($model, 'published_at')->widget(DateTimeWidget::class,
    [
        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
    ]) ?>

<div class="form-group">
    <?php

    echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
        [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
</div>

<?php ActiveForm::end() ?>
