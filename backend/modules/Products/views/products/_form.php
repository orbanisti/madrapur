<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\Products\models\Products;
use lajax\translatemanager\models\Language;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use zxbodya\yii2\galleryManager\GalleryManager;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\Products\models\Services;
use backend\models\Shopcurrency;
use yii\helpers\Json;
use backend\modules\Citydescription\models\Countries;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use backend\modules\Citydescription\models\Citydescription;
\kartik\datetime\DateTimePickerAsset::register($this);
//backend\assets\DatetimepickerAsset::register($this);
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

    <?php if(!$model->isNewRecord && $model->source== Products::SOURCE_GRAYLINE) echo Html::a(Yii::t('app','Weboldal megtekintése'), $model->tour_url, ['target'=>'_blank']).'<br/><br/>'; ?>

    <?= (!$model->isNewRecord && Yii::$app->getModule('users')->isAdmin() && $model->changed!='[]' && $model->changed!='')?'<b>Változások: </b><br/>'.implode(',', Json::decode($model->changed)).'<br/><br/>':''; ?>

    <?php (!(true/*Yii::$app->getModule('users')->isAdmin()*/ || $model->isNewRecord))?Yii::t('app', 'Jutalék').': '.$model->commission.' '.Products::commissiontypes($model->commission_type).'<br/><br/>':'' ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#content" data-toggle="tab"><?= Yii::t('app','Tartalom') ?></a></li>
        <li><a href="#prices" data-toggle="tab"><?= Yii::t('app','Árak') ?></a></li>
        <li><a href="#times" data-toggle="tab"><?= Yii::t('app','Időpontok') ?></a></li>
        <li><a href="#blockedtimes" data-toggle="tab"><?= Yii::t('app','Zárt időpontok') ?></a></li>
        <?php if(!$model->isNewRecord) { ?><li><a href="#translate" data-toggle="tab"><?= Yii::t('app','Tartalom Fordítás') ?></a></li><?php } ?>
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

            <?= $form->field($model, 'currency')->dropDownList(Shopcurrency::getAvaibleTodropdown()); ?>

            <?php
                if(true || $model->isNewRecord) {//Yii::$app->getModule('users')->isAdmin() || $model->isNewRecord) {
                    echo '<div class="col-md-12 nopadding"><div class="col-md-6">';
                    echo $form->field($model, 'commission', ['template' => '<div class="row"><div class="col-md-2 nopadding" style="line-height: 38px;">{label}</div><div class="col-md-10">{input}{error}{hint}</div></div>'])->textInput();
                    echo '</div><div class="col-md-6 nopadding">';
                    echo $form->field($model, 'commission_type')->dropDownList(Products::commissiontypes())->label(false);
                    echo '</div></div>';
                }
            ?>

            <?php //$form->field($model, 'price')->textInput() ?>

            <?php //$form->field($model, "net_prices")->checkbox(); ?>

            <?php
                if(true) {//Yii::$app->getModule('users')->isAdmin()) {
                    echo $form->field($model, 'status')->dropDownList(Products::status());
                } else {
                    echo $form->field($model, 'status')->hiddenInput()->label(false);
                }
            ?>

            <?= $form->field($model, "enquire_only")->checkbox(); ?>

            <?= $form->field($model, "marketplace")->checkbox(); ?>

            <?= $form->field($model, 'marketplace_discount')->textInput() ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php //$form->field($model, 'country')->textInput(['maxlength' => true]) ?>

            <?php //$form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'country_list')->widget(Select2::classname(), [
                'data' => Countries::getList(),
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'tags' => false,
                    'multiple' => true,
                ],
            ]) ?>

            <?php
                $model->country_list=$model->countryids;
                $model->city_list=$model->cityids;
            ?>

            <?= $form->field($model, 'city_list')->widget(Select2::classname(), [
                'data' => Citydescription::getList(),
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    //'minimumInputLength' => 2,
                    /*'ajax' => [
                        'url' => Url::to(['/citydescription/citydescription/getlist']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],*/
                    'tags' => true,
                    'multiple' => true,
                ],
            ]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?php
            echo $form->field($model, 'latitude')->hiddenInput(['id'=>'latitude'])->label(false);
            echo $form->field($model, 'longitude')->hiddenInput(['id'=>'longitude'])->label(false)->hint(Yii::t('app','Jelöld meg a térképen a pontos helyet'));
            ?>

            <div class="">
                <input id="pac-input" class="controls" type="text" placeholder="<?= Yii::t('app','Keresés').'...' ?>">
                <div id="map" style="width: 100%; height: 400px;"></div>
            </div>
            <br/><br/>

            <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

            <?php //$form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= ""//$form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>

            <?php //$form->field($model, 'other_info')->textarea(['rows' => 6]) ?>

            <?= ""//$form->field($model, 'other_info')->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>

            <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
            ]) ?>

            <?= (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['productsPictures'] . $model->image, ['style'=>'max-width: 300px;']):''; ?>

            <?= $form->field($model, 'category_id')->dropDownList(Products::getDropdowncategoriestoadmin(),
                    ['onchange' => '$.ajax({
                        url: "'.Yii::$app->urlManager->createUrl(["/products/services/getlistbycategory"]).'",
                        type: "post",
                        data: {
                            category:$(this).val(),
                            _csrf: "'.Yii::$app->request->getCsrfToken().'"
                        },
                        success: function (data) {
                           $("#products-serviceslist").html(data);
                           $("#allservices").prop("checked", false);
                        }
                   });']
                ); ?>

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
                /*'displayFormat' => 'php:Y-m-d H:i',
                'type'=>DateControl::FORMAT_DATETIME,*/
                'displayFormat' => 'php:Y-m-d',
                'type'=>DateControl::FORMAT_DATE,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]); ?>

            <?= $form->field($model, 'serviceslist')->checkboxList(Services::getServicestochk())->label(Yii::t('app', 'Szolgáltatások').'<br/>'.Html::checkbox('allservices', false, ['id'=>'allservices', 'label'=>Yii::t('app','Mind kijelöl')])); ?>

            <?php
            $this->registerJs('$("#allservices").change(function() {
                if($("#allservices").is(":checked")) {
                    $("#products-serviceslist input").each(function() {
                        $(this).prop("checked", true);
                    });
                } else {
                    $("#products-serviceslist input").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                });');
            ?>

            <?= $form->field($model, 'min_participator')->textInput() ?>

            <?= $form->field($model, 'max_participator')->textInput() ?>

            <?= $form->field($model, 'start_date_delay')->textInput() ?>

            <?php
                echo '<div class="col-md-12 nopadding"><div class="col-md-6">';
                echo $form->field($model, 'duration', ['template' => '<div class="row"><div class="col-md-2 nopadding" style="line-height: 38px;">{label}</div><div class="col-md-10">{input}{error}{hint}</div></div>'])->textInput();
                echo '</div><div class="col-md-6 nopadding">';
                echo $form->field($model, 'duration_type')->dropDownList(Products::durationtype())->label(false);
                echo '</div></div>';
            ?>

            <?php //$form->field($model, 'duration')->textInput().$form->field($model, 'duration_type')->dropDownList(Products::durationtype())->label(false) ?>

            <?php if ($model->isNewRecord) {
                //echo 'Can not upload images for new record';
            } else {
                echo '<br/><label>'.Yii::t('app', 'képek').'</label>';
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
                        'other_info',
                    ],
                ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="glyphicon glyphicon-euro"></i> <?= Yii::t('app', 'Árak') ?>
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelPrices as $i => $modelPrice): $uniqid=uniqid(); ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Ár') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="tabs<?= $uniqid ?>" class="panel-body">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#prices<?= $uniqid ?>" data-toggle="tab" class="pricestab"><?= Yii::t('app','Tartalom') ?></a></li>
                                    <?php if(!$model->isNewRecord) { ?><li><a href="#pricestranslate<?= $uniqid ?>" data-toggle="tab" class="pricestranslatetab">Fordítás</a></li><?php } ?>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="prices<?= $uniqid ?>">
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
                                            <div class="col-sm-2">
                                                <?= $form->field($modelPrice, "[{$i}]net_price")->textInput(); ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?= $form->field($modelPrice, "[{$i}]price")->textInput(); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($modelPrice, "[{$i}]marketplace_discount")->textInput() ?>
                                            </div>
                                            <!--<div class="col-sm-4">
                                                <?php //echo $form->field($modelPrice, "[{$i}]status")->dropDownList(Productsprice::status()); ?>
                                            </div>-->
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="pricestranslate<?= $uniqid ?>">
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
                    </div>

                <?php endforeach; ?>

                </div>

            </div>

        </div>

        <?php DynamicFormWidget::end(); ?>

        </div>

        <div class="tab-pane" id="times">
            <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper_times', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items-times', // required: css class selector
                    'widgetItem' => '.item-times', // required: css class
                    'limit' => 999, // the maximum times, an element can be cloned (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item-times', // css class
                    'deleteButton' => '.remove-item-times', // css class
                    'model' => $modelTimes[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'name',
                    ],
                ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Időpontok') ?>
                    <button type="button" class="add-item-times btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items-times"><!-- widgetContainer -->
                    <?php foreach ($modelTimes as $i => $modelTime): $uniqid=uniqid(); ?>
                        <div class="item-times panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Időpont') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item-times btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item-times btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (!$modelTime->isNewRecord) {
                                    echo Html::activeHiddenInput($modelTime, "[{$i}]id");
                                }
                                echo $form->field($modelTime, "[{$i}]product_id")->hiddenInput(['value'=>$model->id])->label(false);
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $form->field($modelTime, "[{$i}]name")->textInput(['class'=>'form-control']) ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= $form->field($modelTime, "[{$i}]all_time")->checkbox() ?>
                                </div>
                                <div class="col-sm-6">
                                    
                                   <?= $form->field($modelTime, "[{$i}]start_date")->widget(DateControl::classname(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'autoWidget' => true,
                                            'displayFormat' => 'php:Y-m-d',
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true
                                                ]
                                            ]
                                        ]); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($modelTime, "[{$i}]end_date")->widget(DateControl::classname(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'autoWidget' => true,
                                            'displayFormat' => 'php:Y-m-d',
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true
                                                ]
                                            ]
                                        ]); ?>
                                </div>
                            </div><!-- .row -->
                        </div>
                    </div>

                <?php endforeach; ?>

                </div>
            </div>
        </div>
            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="tab-pane" id="blockedtimes">
            <?= $form->field($model, 'allowed_days_list')->checkboxList(Products::alloweddays())
                    ->label(Yii::t('app', 'Engedélyezett napok').'<br/>'.Html::checkbox('alldays', false, ['id'=>'alldays', 'label'=>Yii::t('app','Mind kijelöl')]))
                    ->hint(Yii::t('app', 'Ha egy sincs kiválasztva, akkor alapértelmezetten minen nap engedélyezve van.')); ?>
            <?php
            $this->registerJs('$("#alldays").change(function() {
                if($("#alldays").is(":checked")) {
                    $("#products-allowed_days_list input").each(function() {
                        $(this).prop("checked", true);
                    });
                } else {
                    $("#products-allowed_days_list input").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                });');

            echo $form->field($model, 'blockoutsdates')->widget(DatePicker::classname(), [
                //'id' => 'products-blockoutsdates',
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'multidate' => true,
                    'multidateSeparator' => ',',
                ]
            ]);
            ?>
            <div class="add-remove-dates">
                <div class="col-md-3">
                    <?= DatePicker::widget([
                        'name' => 'bo-from-date',
                        'id' => 'bo-from-date',
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => date('Y-m-d'),
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>
                </div>
                <div class="pull-left">-</div>
                <div class="col-md-3">
                    <?= DatePicker::widget([
                        'name' => 'bo-end-date',
                        'id' => 'bo-end-date',
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => date('Y-m-d'),
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>

                <div id="add-dates" class="btn btn-default"><?= Yii::t('app','Hozzáadás') ?></div>
                <div id="remove-dates" class="btn btn-default"><?= Yii::t('app','Törlés') ?></div>
                <script>

                    $( document ).ready(function() {

                        $("#add-dates").click(function(){
                            var date1=$("#bo-from-date").val();
                            var date2=$("#bo-end-date").val();
                            var dates=$("#products-blockoutsdates").val();
                            var manager = new DateManager();
                            //console.log(dates);
                            if (dates == '') {
                                dates=manager.getDatesBetween(date1, date2);
                            } else {
                                dates=dates.split(',')
                                dates=$.merge(dates,manager.getDatesBetween(date1, date2));
                            }
                            $('#products-blockoutsdates-kvdate').kvDatepicker('setDates', unique(dates).sort());
                        });

                        $("#remove-dates").click(function(){
                            var date1=$("#bo-from-date").val();
                            var date2=$("#bo-end-date").val();
                            var dates=$("#products-blockoutsdates").val();
                            var manager = new DateManager();
                            //console.log(dates);
                            if (dates == '') {
                                dates=manager.getDatesBetween(date1, date2);
                            } else {
                                dates=dates.split(',')

                                //dates=$.merge(dates,manager.getDatesBetween(date1, date2));
                                var removedates=manager.getDatesBetween(date1, date2);
                                dates=dates.filter(function(item) {
                                    return removedates.indexOf(item) === -1;
                                });
                            }
                            $('#products-blockoutsdates-kvdate').kvDatepicker('setDates', unique(dates).sort());
                        });

                        function unique(list) {
                            var result = [];
                            $.each(list, function(i, e) {
                              if ($.inArray(e, result) == -1) result.push(e);
                            });
                            return result;
                        }

                        function DateManager(){
                            // Create a date with specific day
                            function setDate(date, day){
                                date = new Date(date);
                                date.setDate(day);
                                date.setHours(23);
                                return date;
                            }

                            var padZero = function (integer) {
                                return integer < 10 ? '0' + integer : '' + integer
                            };

                            // Generate dates method
                            this.getDatesBetween = function(date1, date2){
                                var date1 = new Date(date1);
                                var date2 = new Date(date2);
                                var dates = [];
                                var temp = '';
                                while(date1 <= date2){
                                    temp = date1.getFullYear() + '-' + (padZero(date1.getMonth()+1)) + '-' + (padZero(date1.getDate()));
                                    dates.push(temp);
                                    date1 = new Date(date1.getTime() + 1*24*60*60*1000); //1 nap hozzáadása
                                }

                                return dates;
                            };
                        }
                    });
                </script>
            </div>
        </div>

        <?php if(!$model->isNewRecord) { ?>
            <div class="tab-pane" id="translate">
                <ul class="nav nav-tabs">
                    <?php
                    $first=true;
                    foreach (Language::getLanguages() as $language) {
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
                        <?= $form->field($translation, "[{$langId}]description")->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>
                        <?= $form->field($translation, "[{$langId}]other_info")->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    <div class="form-group">
        <br/>
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
        /*list=item.getElementsByTagName("input");
        for (var i = 0; i < list.length; i++) {
            console.log(list[i].id); //second console output
            //console.log(list[i].value);
        }*/
        list=item.getElementsByClassName("tab-pane");
        for (var i = 0; i < list.length; i++) {
            var arr = list[i].id.split("-");
            if(arr[0]=="pricestranslate")
                $(".pricestranslatetab").last().attr("href","#"+list[i].id);
            else
                $(".pricestab").last().attr("href","#"+list[i].id);
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

    $this->registerJs('
    $(".dynamicform_wrapper_times").on("beforeInsert", function(e, item) {
        console.log("beforeInsert");
    });

    $(".dynamicform_wrapper_times").on("afterInsert", function(e, item) {
        console.log("afterInsert");
    });

    $(".dynamicform_wrapper_times").on("beforeDelete", function(e, item) {
        if (! confirm("Biztos, hogy törölni akarod?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper_times").on("afterDelete", function(e) {
        console.log("Deleted item!");
    });

    $(".dynamicform_wrapper_times").on("limitReached", function(e, item) {
        alert("Limit elérve");
    });
    ');
?>

    <script>
        $(document).ready(function() {
            $("#pac-input").keydown(function(event){
              if(event.keyCode == 13) {
                event.preventDefault();
                return false;
              }
            });
        });

        var map;
        var marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                <?php
                if($model->latitude!=0 && $model->longitude!=0) {
                    echo 'center: { lat: '.$model->latitude.', lng: '.$model->longitude.' },';
                    echo 'zoom: 12,';
                } else {
                    echo 'center: { lat: 47.49261677528683, lng: 19.047975540161133 },';
                    echo 'zoom: 4,';
                }
                ?>
                streetViewControl: false,
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
              searchBox.setBounds(map.getBounds());
            });

            google.maps.event.addListener(map, 'click', function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                //console.log(event.latLng.lat()+", "+event.latLng.lng());
                $("#latitude").val(event.latLng.lat());
                $("#longitude").val(event.latLng.lng());
                placeMarker(event.latLng);
            });

            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    $("#latitude").val(place.geometry.location.lat());
                    $("#longitude").val(place.geometry.location.lng());
                    map.setCenter(place.geometry.location);
                    placeMarker(place.geometry.location);
                });

            });

            function placeMarker(location) {
                if (!marker) {
                    marker = new google.maps.Marker({
                    position: location,
                    map: map
                    });
                } else { marker.setPosition(location); }
            }

            <?php
                if($model->latitude!=0 && $model->longitude!=0) {
                    echo 'var location = new google.maps.LatLng('.$model->latitude.', '.$model->longitude.');';
                    echo 'marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });';
                }
            ?>
        }

    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= 1//Yii::$app->params['googleMapsApiKey'] ?>&callback=initMap&language=<?= substr(Yii::$app->language, 0, 2) ?>&libraries=places" async defer></script>


