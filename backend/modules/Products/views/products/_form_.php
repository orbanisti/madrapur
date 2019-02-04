<?phpbackend\backend\

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\Products\models\Products;
use lajax\translatemanager\models\Language;
use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use zxbodya\yii2\galleryManager\GalleryManager;
use wbraganca\dynamicform\DynamicFormWidget;
use app\modules\Products\models\Productsprice;
?>

<?php
    if(Yii::$app->session->hasFlash('error'))
    {
        echo '<p class="has-error flashes"><span class="help-block help-block-error">'.Yii::$app->session->getFlash('error').'</span></p>';
    } elseif(Yii::$app->session->hasFlash('success'))
    {
        echo '<p class="has-success flashes"><span class="help-block help-block-success">'.Yii::$app->session->getFlash('success').'</span></p>';
    }
?>

<div class="products-form">
    
    <?php $form = ActiveForm::begin([
        //'enableClientValidation' => false
        'id' => 'dynamic-form',
        'options'=>['enctype'=>'multipart/form-data']
        ]); ?>
    
    <?= $form->errorSummary($modelPrices); ?>
    
    <?= (!$model->isNewRecord)?Yii::t('app','Létrehozta').': '.$model->user->username.'<br/><br/>':''; ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#content" data-toggle="tab"><?= Yii::t( 'app', 'Tartalom') ?></a></li>
        <li><a href="#prices" data-toggle="tab"><?= Yii::t( 'app', 'Árak') ?></a></li>
        <?php if(!$model->isNewRecord) { ?><li><a href="#translate" data-toggle="tab"><?= Yii::t( 'app', 'Tartalom Fordítás') ?></a></li><?php } ?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="content">

            <?php
            
             if($model->isNewRecord) {
                    echo $form->field($model, 'lang_code')->dropDownList(\lajax\translatemanager\models\Language::getLanguageNames(true));
                } else {
                    echo $form->field($model, 'lang_code')->hiddenInput()->label(false);
                    $language=\lajax\translatemanager\models\Language::findOne(['language_id'=>$model->lang_code]);
                    echo Yii::t('app','Nyelv').': '.$language->name.'<br/><br/>';
                }
            ?>
            
            <?php
                if(Yii::$app->getModule('users')->isAdmin()) {
                    echo $form->field($model, 'status')->dropDownList(Products::status());
                } else {
                    echo $form->field($model, 'status')->hiddenInput()->label(false);
                }
            ?>
            
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
            ]) ?>

            <?= (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['productsPictures'] . $model->image, ['style'=>'max-width: 300px;']):''; ?>

            <?= $form->field($model, 'category_id')->dropDownList(Products::getDropdowncategories()) ?>

            <?php // $form->field($model, 'price')->textInput() ?>

            <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
                'ajaxConversion'=>false,
                'autoWidget'=>true,
                'displayFormat' => 'php:Y-m-d',
                'type'=>DateControl::FORMAT_DATE,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]); ?>

            <?= $form->field($model, 'end_date')->widget(DateControl::classname(), [
                'ajaxConversion'=>false,
                'autoWidget'=>true,
                'displayFormat' => 'php:Y-m-d',
                'type'=>DateControl::FORMAT_DATE,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]); ?>

            <?= $form->field($model, 'max_participator')->textInput() ?>
            
            <?= $form->field($model, 'duration')->textInput().$form->field($model, 'duration_type')->dropDownList(Products::durationtype())->label(false) ?>

            <?php if ($model->isNewRecord) {
                //echo 'Can not upload images for new record';
            } else {
                echo '<br/>'.Yii::t('app', 'képek');
                echo GalleryManager::widget(
                    [
                        'model' => $model,
                        'behaviorName' => 'galleryBehavior',
                        'apiRoute' => 'products/galleryApi'
                    ]
                );
            }
            ?>

        </div>
        
        <div class="tab-pane" id="prices">
            <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 999, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelPrices[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'name',
                        'description',
                    ],
                ]); ?>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="glyphicon glyphicon-euro"></i> Árak
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Új</button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelPrices as $i => $modelPrice): $uniqid=uniqid(); ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Ár</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">

                                        <?php
                                            // necessary for update action.
                                            if (!$modelPrice->isNewRecord) {
                                                echo Html::activeHiddenInput($modelPrice, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($modelPrice, "[{$i}]name")->textInput(); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($modelPrice, "[{$i}]description")->textInput(); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($modelPrice, "[{$i}]price")->textInput(); ?>
                                            </div>
                                            <!--<div class="col-sm-4">
                                                <?php //echo $form->field($modelPrice, "[{$i}]status")->dropDownList(Productsprice::status()); ?>
                                            </div>-->
                                    <?php if(!$model->isNewRecord) {
                                        foreach (Language::getLanguages() as $language) {
                                                    if($language->language_id!=$model->lang_code) {
                                                        $langId=$language->language_id;
                                                            echo $language->name.'<br/>';
                                                            echo $form->field($modelPrice, "[{$i}]nametranslate[{$langId}]")->textInput(['maxlength' => true]);
                                                            echo $form->field($modelPrice, "[{$i}]descriptiontranslate[{$langId}]")->textarea(['maxlength' => true]);
                                                    }   
                                                }
                                            ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
        
        </div>

        <?php if(!$model->isNewRecord) { ?>
            <div class="tab-pane" id="translate">
                <ul class="nav nav-tabs">
                    <?php 
                    $first=true;
                    foreach (Language::getLanguages() as $language) {
                        //if($language->language_id!=Yii::$app->sourceLanguage) {
                        if($language->language_id!=$model->lang_code) {
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

                        <?= $form->field($translation, "[{$langId}]name")->textInput(['maxlength' => true]) ?>

                        <?= $form->field($translation, "[{$langId}]intro")->textarea(['maxlength' => true]) ?>

                        <?= $form->field($translation, "[{$langId}]description")->textarea(['rows' => 6]) ?>

                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Létrehozás') : Yii::t('app', 'Módosítás'), ['class' => 'btn']) ?>
    </div>

    </div>

    <?php ActiveForm::end(); ?>

    

</div>

<?php
    $this->registerJs('
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        console.log("beforeInsert");
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        console.log("afterInsert");
        list=item.getElementsByTagName("input");
        for (var i = 0; i < list.length; i++) {
            console.log(list[i].id); //second console output
            //console.log(list[i].value);
        }
    });

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Biztos, hogy törölni akarod?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper").on("afterDelete", function(e) {
        console.log("Deleted item!");
    });

    $(".dynamicform_wrapper").on("limitReached", function(e, item) {
        alert("Limit elérve");
    });
    ');
?>