<?php



use yii\helpers\Html;

use yii\widgets\ActiveForm;

use app\modules\Products\models\Products;

use lajax\translatemanager\models\Language;

use kartik\datecontrol\DateControl;

use kartik\file\FileInput;

use zxbodya\yii2\galleryManager\GalleryManager;

use wbraganca\dynamicform\DynamicFormWidget;

use app\modules\Products\models\Services;

use app\models\Shopcurrency;

use yii\helpers\Json;

use kartik\date\DatePicker;

?>





<div class="products-form">

    

    <h1><?= Yii::t('app','Termék feltöltési útmutató') ?></h1>

    

    <?php $form = ActiveForm::begin([

        'enableClientValidation' => false,

        'id' => 'dynamic-form',

        'options'=>['enctype'=>'multipart/form-data']

        ]); ?>

    

    <?= $form->errorSummary($modelPrices); ?>

    

    <?= (!$model->isNewRecord)?Yii::t('app','Létrehozta').': '.$model->user->username.'<br/><br/>':''; ?>



    <?= (!$model->isNewRecord && Yii::$app->getModule('users')->isAdmin() && $model->changed!='[]' && $model->changed!='')?'<b>Változások: </b><br/>'.implode(',', Json::decode($model->changed)).'<br/><br/>':''; ?>

    

    <?php (!(Yii::$app->getModule('users')->isAdmin() || $model->isNewRecord))?Yii::t('app', 'Jutalék').': '.$model->commission.' '.Products::commissiontypes($model->commission_type).'<br/><br/>':'' ?>



    <ul class="nav nav-tabs">

        <li class="active"><a href="#content" data-toggle="tab"><?= Yii::t('app','Tartalom') ?></a></li>

        <li><a href="#prices" data-toggle="tab"><?= Yii::t('app','Árak') ?></a></li>

        <li><a href="#times" data-toggle="tab"><?= Yii::t('app','Időpontok') ?></a></li>

        <li><a href="#blockedtimes" data-toggle="tab"><?= Yii::t('app','Zárt időpontok') ?></a></li>

        <li><a href="#translate" data-toggle="tab"><?= Yii::t('app','Tartalom Fordítás') ?></a></li>

    </ul>



    <div class="tab-content">

        <div class="tab-pane active" id="content">



            <?php

                $model->lang_code=Yii::t('app','Válassza ki a nyelvet, például magyar');

                echo $form->field($model, 'lang_code')->textInput(['readonly' => true]);

            ?>



            <?php

                $model->currency=Yii::t('app','Válassza ki a fizetőeszközt')."\n".Yii::t('app','Ön a listából bármely valutát kiválaszthatja, azonban a programokért jelenleg kizárólag Euróban, illetve magyar forintban lehet fizetni.');

                echo $form->field($model, 'currency')->textarea(['readonly' => true]);

            ?>

            

            <?php

                if(Yii::$app->getModule('users')->isAdmin() || $model->isNewRecord) {

                    echo '<div class="col-md-12 nopadding"><div class="col-md-6">';

                    $model->commission=Yii::t('app','Adja meg a termékre vonatkozó jutalék összegét, és annak jellegét');

                    echo $form->field($model, 'commission', ['template' => '<div class="row"><div class="col-md-2 nopadding" style="line-height: 38px;">{label}</div><div class="col-md-10">{input}{error}</div>{hint}</div>'])->textarea(['readonly' => true]);

                    echo '</div><div class="col-md-6 nopadding">';

                    echo $form->field($model, 'commission_type')->dropDownList(Products::commissiontypes())->label(false);

                    echo '</div></div>';

                }

            ?>

            

            <?= $form->field($model, "marketplace")->checkbox()->hint(Yii::t('app','Pipálja ki a piactér rubrikát, ha kedvezményt szeretne adni az alábbi termékre')); ?>

            

            <?php

                $model->marketplace_discount=Yii::t('app','Adja meg az Ön által megadott kedvezmény mértékét (százalékban)');

                echo $form->field($model, "marketplace_discount")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->name=Yii::t('app','Adja meg a termék nevét');

                echo $form->field($model, "name")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->country=Yii::t('app','Adja meg a program helyszínét (ország)');

                echo $form->field($model, "country")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->city=Yii::t('app','Adja meg a program helyszínét (város)');

                echo $form->field($model, "city")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->address=Yii::t('app','Adja meg a program kiindulási pontját');

                echo $form->field($model, "address")->textInput(['readonly' => true]);

            ?>

            

            <?php 

            echo $form->field($model, 'latitude')->hiddenInput(['id'=>'latitude'])->label(false);

            echo $form->field($model, 'longitude')->hiddenInput(['id'=>'longitude'])->label(false)->hint(Yii::t('app','Jelöld meg a térképen a pontos helyet'));

            ?>

            

            <div id="map" style="width: 100%; height: 400px;"></div><br/><br/>

            

            <?php

                $model->intro=Yii::t('app','A program jellemzése röviden');

                echo $form->field($model, "intro")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->description=Yii::t('app','A program / túra/ kirándulás jellemzése');

                echo $form->field($model, "description")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->other_info=Yii::t('app','Adja meg a programra vonatkozó lényeges információkat( amennyiben a program nem indul minden nap az esetleges indulási napokat, az árban foglaltakat, felmerülő extra költségeket… stb.)');

                echo $form->field($model, "other_info")->textarea(['readonly' => true]);

            ?>

            

            <?php

                $model->image=Yii::t('app','Töltsön fel egy képet, melyet szeretne a program profilképeként látni');

                echo $form->field($model, "image")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->category_id=Yii::t('app','Válassza ki a programra leginkább jellemzőt');

                echo $form->field($model, "category_id")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->start_date=Yii::t('app','A program érvényességének kezdete');

                echo $form->field($model, "start_date")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->end_date=Yii::t('app','A program lejárati dátuma (A program aktuális jellemzőinek, árainak lejárati dátuma)');

                echo $form->field($model, "end_date")->textInput(['readonly' => true]);

            ?>

            

            <?= $form->field($model, 'serviceslist', ['template' => '<div class="form-group">{label}{hint}<div>{input}{error}</div></div>'])->checkboxList(Services::getServicestochk())->label(Yii::t('app', 'Szolgáltatások').'<br/>'.Html::checkbox('allservices', false, ['id'=>'allservices', 'label'=>Yii::t('app','Mind kijelöl')]))->hint(Yii::t('app','Pipálja ki a feltölteni kívánt programra jellemzőket')); ?>

            

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



            <?php

                $model->min_participator=Yii::t('app','A program indulásához szükséges legkevesebb fő száma');

                echo $form->field($model, "min_participator")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->max_participator=Yii::t('app','A programon reszt vehető legtöbb fő száma');

                echo $form->field($model, "max_participator")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->start_date_delay=Yii::t('app','Amennyiben az Ön által feltölteni kívánt program előre foglalást igényel, ide írja be, hogy pontosan hány nappal előre érkezzen be a foglalás');

                echo $form->field($model, "start_date_delay")->textInput(['readonly' => true]);

            ?>

            

            <?php

                $model->duration=Yii::t('app','A program hossza (nap, óra, perc)');

                echo '<div class="col-md-12 nopadding"><div class="col-md-6">';

                echo $form->field($model, 'duration', ['template' => '<div class="row"><div class="col-md-2 nopadding" style="line-height: 38px;">{label}</div><div class="col-md-10">{input}{error}</div>{hint}</div>'])->textInput(['readonly' => true]);

                echo '</div><div class="col-md-6 nopadding">';

                echo $form->field($model, 'duration_type')->dropDownList(Products::durationtype())->label(false);

                echo '</div></div>';

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

                                                <?= $form->field($modelPrice, "[{$i}]name")->textarea(['readonly'=>true, 'value'=>Yii::t('app','A jegy típusa (Felnőtt, gyerek, csecsemő)')]); ?>

                                            </div>

                                            <div class="col-sm-4">

                                                <?= $form->field($modelPrice, "[{$i}]description")->textarea(['readonly'=>true, 'value'=>Yii::t('app','Extra információ a programról ( pl.: 24 órás jegy,)')]); ?>

                                            </div>

                                            <div class="col-sm-2">

                                                <?= $form->field($modelPrice, "[{$i}]net_price")->textarea(['readonly'=>true, 'value'=>Yii::t('app','A termék nettó ára + ÁFA -> A jutalék nélküli eladási ár')]); ?>

                                            </div>

                                            <div class="col-sm-2">

                                                <?= $form->field($modelPrice, "[{$i}]price")->textarea(['readonly'=>true, 'value'=>Yii::t('app','A nettó ár + jutalék -> Az ár, amin a termék eladásra kerül')]); ?>

                                            </div>

                                            <div class="col-sm-4">

                                                <?= $form->field($modelPrice, "[{$i}]marketplace_discount")->textarea(['readonly'=>true, 'value'=>Yii::t('app','A programra adott kedvezmény mértéke')]) ?>

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

                    <h4><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Időpontok').' ('.Yii::t('app','Ha az Ön terméke megadott időpontokban indul, azt itt tudja feltüntetni<br/>Kattintson a „Létrehozás” gombra').')' ?>

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

                                <div class="col-sm-4">

                                    <?= $form->field($modelTime, "[{$i}]name")->textInput(['class'=>'form-control']) ?>

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

            <?= $form->field($model, 'allowed_days_list', ['template' => '<div class="form-group">{label}{hint}<div>{input}{error}</div></div>'])->checkboxList(Products::alloweddays())

                    ->label(Yii::t('app', 'Engedélyezett napok').'<br/>'.Html::checkbox('alldays', false, ['id'=>'alldays', 'label'=>Yii::t('app','Mind kijelöl')]))

                    ->hint(Yii::t('app', 'Alkalmazza a nap kijelölést, ha a program csak azokon a napokon elérhető/indul')); ?>

            

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

            ?>

            <?php //Yii::$app->extra->e($model->blockoutsdates); ?>

            <?php /*echo $form->field($model, 'blockoutsdates')->widget(DateControl::classname(), [

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

            ]);*/ 

            $model->blockoutsdates=Yii::t('app', 'Zárja ki azokat a napokat, amikor az Ön programja egyáltalán nem indul');

            echo $form->field($model, 'blockoutsdates')->textInput(['readonly'=>true]); ?>

            <script>

                $( document ).ready(function() {

                    //$('#products-blockoutsdates-disp').val('<?= $model->blockoutsdates ?>');

                });

            </script>

        </div>



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



                        <?= $form->field($translation, "[{$langId}]description")->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>

                        

                        <?= $form->field($translation, "[{$langId}]other_info")->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className(),[ 'clientOptions' => [ 'lang' => Yii::$app->language, 'minHeight' => 300, 'imageManagerJson' => Yii::$app->extra->getMainhost().'/redactor/upload/image-json', 'imageUpload' => WEB_ROOT.'/upload/image', 'fileUpload' => WEB_ROOT.'/upload/file', 'imageUpload' => Yii::$app->extra->getMainhost().'/redactor/upload/image', 'plugins' => ['clips', 'fontcolor','table','fullscreen'] ] ]) ?>



                    </div>

                    <?php } ?>

                </div>

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

            google.maps.event.addListener(map, 'click', function(event) {

                var lat = event.latLng.lat();

                var lng = event.latLng.lng();

                //console.log(event.latLng.lat()+", "+event.latLng.lng());

                $("#latitude").val(event.latLng.lat());

                $("#longitude").val(event.latLng.lng());

                placeMarker(event.latLng);

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



<script src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->params['googleMapsApiKey'] ?>&callback=initMap&language=<?= substr(Yii::$app->language, 0, 2) ?>" async defer></script>

