<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lajax\translatemanager\models\Language;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\Citydescription\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-form">

    <?php $form = ActiveForm::begin([
        //'enableClientValidation' => false
        'id' => 'countries-form',
        'options'=>['enctype'=>'multipart/form-data']
        ]); ?>
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>
        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane active" id="content">

            <?= $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'country_name')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
            ]) ?>
            
            <?= (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['countriesPictures'] . $model->image, ['style'=>'max-width: 300px;']).'<br/><br/>':''; ?>

            <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'population')->textInput() ?>

            <?= $form->field($model, 'capital')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'area_size')->textInput() ?>

            <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(),[
                'clientOptions' => [
                    'lang' => Yii::$app->language,
                    'minHeight' => 300,
                    'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json',
                    'imageUpload' => WEB_ROOT.'/upload/image',
                    'fileUpload' => WEB_ROOT.'/upload/file',
                    'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image',
                    'plugins' => ['clips', 'fontcolor','imagemanager','video','table','filemanager','fullscreen']
                ]
            ]) ?>
            
            <?= $form->field($model, 'extra_info')->widget(\yii\redactor\widgets\Redactor::className(),[
                'clientOptions' => [
                    'lang' => Yii::$app->language,
                    'minHeight' => 300,
                    'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json',
                    'imageUpload' => WEB_ROOT.'/upload/image',
                    'fileUpload' => WEB_ROOT.'/upload/file',
                    'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image',
                    'plugins' => ['clips', 'fontcolor','imagemanager','video','table','filemanager','fullscreen']
                ]
            ]) ?>
            
        </div>

        <div class="tab-pane" id="translate">
            <ul class="nav nav-tabs">
                <?php 
                $first=true;
                foreach (Language::getLanguages() as $language) {
                    if($language->language_id!=Yii::$app->sourceLanguage) {
                        $langId=$language->language_id;
                        $liclass=($first)?' class="active"':'';
                        if($first) $firstlang=$language->language_id;
                        $first=false;
                        echo '<li'.$liclass.'><a href="#'.$langId.'" data-toggle="tab">'.$language->name.'</a></li>';
                    }
                }
                ?>
            </ul>
            
            <div class="tab-content">
                <?php 
                foreach ($modelTranslations as $langId=>$translation) {
                $liclass=($firstlang==$translation->lang_code)?' active':'';
                ?>

                <div class="tab-pane<?= $liclass ?>" id="<?= $translation->lang_code ?>">

                <?= $form->field($translation, "[{$langId}]country_name")->textInput(['maxlength' => true]) ?>
                    
                <?= $form->field($translation, "[{$langId}]capital")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]content")->widget(\yii\redactor\widgets\Redactor::className(),[
                    'clientOptions' => [
                        'lang' => Yii::$app->language,
                        'minHeight' => 300,
                        'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json',
                        'imageUpload' => WEB_ROOT.'/upload/image',
                        'fileUpload' => WEB_ROOT.'/upload/file',
                        'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image',
                        'plugins' => ['clips', 'fontcolor','imagemanager','video','table','filemanager','fullscreen']
                    ]
                ]) ?>
                    
                <?= $form->field($translation, "[{$langId}]extra_info")->widget(\yii\redactor\widgets\Redactor::className(),[
                    'clientOptions' => [
                        'lang' => Yii::$app->language,
                        'minHeight' => 300,
                        'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json',
                        'imageUpload' => WEB_ROOT.'/upload/image',
                        'fileUpload' => WEB_ROOT.'/upload/file',
                        'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image',
                        'plugins' => ['clips', 'fontcolor','imagemanager','video','table','filemanager','fullscreen']
                    ]
                ]) ?>
                
                </div>

                <?php } ?>

            </div>

        </div>
        
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Mentés'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
