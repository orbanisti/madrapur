<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 *
 * @var $this yii\web\View
 * @var $model common\models\Page
 */

$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]);

echo $form->field($model, 'name')->textInput(['maxlength' => true]);

/*echo $form->field($model, 'body')->widget(\yii\imperavi\Widget::class,
        [
            'plugins' => [
                'fullscreen',
                'fontcolor',
                'video'
            ],
            'options' => [
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'imageUpload' => Yii::$app->urlManager->createUrl([
                    '/file/storage/upload-imperavi'
                ]),
            ],
        ]);

*/

$editLink = '/Modulusbuilder/modulusbuilder/admin?slug=' . $model->id;
echo($model->isNewRecord ? $form->field($model, 'body')->hiddenInput(['value' => '<div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Madrapur start page</h1>
          <p class="lead">Start by dragging components to page or double click to edit text</p>
        </div>
      </div>
    </div>'])->label(false) : Html::a('Edit in pagebuilder', [$editLink], ['class' => 'btn btn-primary']));

?>

<div class="form-group">
    <?php
    foreach ($model->fields() as $field) {
        if (strpos($field, "meta") === 0) {
            echo $form->field($model, $field)->textInput();
        }
    }
    ?>
</div>

<div class="form-group">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
