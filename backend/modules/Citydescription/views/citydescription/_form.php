<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zxbodya\yii2\galleryManager\GalleryManager;
use lajax\translatemanager\models\Language;
use kartik\select2\Select2;
use backend\modules\Products\models\Cities;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use backend\modules\Citydescription\models\Countries;
//kartik\file\FileInputAsset::register($this);

?>

<div class="citydescription-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>
        <li><a href="#sights" data-toggle="tab">Látnivalók</a></li>
        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="content">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'short_info')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'country_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Countries::find()->all(), 'id', 'country_name'),
                'language' => 'hu',
                'pluginOptions' => [
                    'allowClear' => false,
                    //'disabled' => $isanswer,
                ],
            ]); ?>

            <?php
            /*$this->registerJs('
                $("#city-image").fileinput({allowedFileExtensions: ["jpg","gif","png"], showUpload:false});
            ');*/
            ?>

            <!--<input id="city-image" name="Citydescription[image]" type="file" class="file" data-preview-file-type="text">-->

            <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
            ]) ?>

            <?= (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['citiesPictures'] . $model->image, ['style'=>'max-width: 300px;']).'<br/><br/>':''; ?>

            <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'transport')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'plug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'when')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sights_info')->textarea(['maxlength' => true]) ?>

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

            <?php if ($model->isNewRecord) {
            //echo 'Can not upload images for new record';
            } else {
                echo GalleryManager::widget(
                    [
                        'model' => $model,
                        'behaviorName' => 'galleryBehavior',
                        'apiRoute' => 'citydescription/galleryApi'
                    ]
                );
            }
            ?>
        </div>

        <div class="tab-pane" id="sights">
            <?= $this->render('_form_sights', [
                'form' => $form,
                'model' => $model,
                'sights' => $sights
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
                //$first=true;
                foreach ($modelTranslations as $langId=>$translation) {
                //$liclass=($first)?' active':''; $first=false;
                $liclass=($firstlang==$translation->lang_code)?' active':'';
                ?>

                <div class="tab-pane<?= $liclass ?>" id="<?= $translation->lang_code ?>">

                <?php
                //$lang=Language::findOne(['language_id'=>$langId]);
                //echo '<h2>'.$lang->name.'</h2>';
                ?>

                <?php //$form->field($translation, "[{$langId}]lang_code")->hiddenInput(['value'=>$translation->lang_code])->label(false); ?>

                <?= $form->field($translation, "[{$langId}]title")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]short_info")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]currency")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]language")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]phone_code")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]transport")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]plug")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]when")->textInput(['maxlength' => true]) ?>

                <?= $form->field($translation, "[{$langId}]sights_info")->textarea(['maxlength' => true]) ?>

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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Létrehozás') : Yii::t('app', 'Módosítás'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

