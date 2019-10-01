<?php


use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

        DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_times', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items-times', // required: css class selector
            'widgetItem' => '.item-times', // required: css class
            'limit' => 10, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item-times', // css class
            'deleteButton' => '.remove-item-times', // css class
            'model' => $modelTimes[0],
            'formId' => 'product-edit',
            'formFields' => [
                'name',
            ],
        ]);
        ?>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h4><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Product Times') ?>
                    <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
                    <button type="button" class="add-item-times btn btn-info btn-sm pull-right"><i
                                class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>

                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items-times"><!-- widgetContainer -->
                    <?php foreach ($modelTimes as $i => $modelTime): ?>
                        <div class="item-times panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">

                                <h3 class="panel-title pull-left"><?= Yii::t('app', 'Időpont') ?></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item-times btn btn-info btn-xs"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item-times btn btn-danger btn-xs"><i
                                                class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.

                                echo Html::activeHiddenInput($modelTime, "[{$i}]id");

                                echo $form->field($modelTime, "[{$i}]product_id")->hiddenInput(['value' => $model->id])->label(false);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($modelTime, "[{$i}]name")->textInput(['class' => 'form-control']) ?>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                    <div class="col-sm-6">

                                        <?= $form->field($modelTime, "[{$i}]start_date")->widget(DateControl::class, [
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
