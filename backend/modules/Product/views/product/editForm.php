<?php
use backend\modules\Product\models\ProductUpdate;
use yii\widgets\ActiveForm;
use \yii\helpers\Html;

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


<ul class="nav nav-tabs">
    <li class="active"><a href="#content" data-toggle="tab"><?= Yii::t('app','Tartalom') ?></a></li>
    <li><a href="#prices" data-toggle="tab"><?= Yii::t('app','Árak') ?></a></li>
    <li><a href="#times" data-toggle="tab"><?= Yii::t('app','Időpontok') ?></a></li>
   </ul>



<div class="tab-content">
    <div class="tab-pane active" id="content">



    <?php
    if(Yii::$app->session->hasFlash('error'))
    {
        echo '<p class="has-error flashes"><span class="help-block help-block-error">'.Yii::$app->session->getFlash('error').'</span></p>';
    } elseif(Yii::$app->session->hasFlash('success'))
    {
        echo '<p class="has-success flashes"><span class="help-block help-block-success">'.Yii::$app->session->getFlash('success').'</span></p>';
    }




$form = ActiveForm::begin([
    'id' => 'product-edit',
    'action' => 'update?prodId='.$prodId,
    'options' => ['class' => 'prodUpdate'],
]);?>
<?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
<?='<br/>'?>


  <?=$form->field($model, 'currency')->dropDownList(array('HUF' => 'HUF', 'EUR' => 'EUR',), array('options' => array('HUF' => array('selected' => true))));?>
  <?=$form->field($model, 'status')->dropDownList(array('active' => 'active', 'inactive' => 'inactive',), array('options' => array('active' => array('selected' => true))));?>
  <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => ['/redactor/upload/image'],
            'fileUpload' => ['/redactor/upload/file'],
            'lang' => 'hu_HU',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ])?>
    <?= $form->field($model, 'short_description')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => ['/redactor/upload/image'],
            'fileUpload' => ['/redactor/upload/file'],
            'lang' => 'hu_HU',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ])?>
  <?= $form->field($model, 'category')->textInput(['maxlenght' => 60]) ?>
  <?= $form->field($model, 'capacity')->textInput(['maxlenght' => 60]) ?>
  <?= $form->field($model, 'duration')->textInput(['maxlenght' => 60]) ?><?='(in minutes)'?>

<?= $form->field($model, 'images')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
]) ?>

<?php // (!$model->isNewRecord && $model->image!='')?Html::img(Yii::$app->params['productsPictures'] . $model->image, ['style'=>'max-width: 300px;']):''; ?>



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


    <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
    </div>


    <div class="tab-pane active" id="prices">

    </div>
    <div class="tab-pane active" id="times">



        <?php
        //var_dump($modelTimes);
        DynamicFormWidget::begin([
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
                'name'
            ],
        ]);
        ?>

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

</div>


