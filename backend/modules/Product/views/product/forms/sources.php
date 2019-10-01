

<?php


use wbraganca\dynamicform\DynamicFormWidget;
use kartik\helpers\Html;
use kartik\datecontrol\DateControl;

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_sources', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-sources', // required: css class selector
    'widgetItem' => '.item-sources', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item-sources', // css class
    'deleteButton' => '.remove-item-sources', // css class
    'model' => $modelSources[0],
    'formId' => 'product-edit',
    'formFields' => [
        'name',
    ],
]);
?>

<div class="panel panel-default">

    <div class="panel-heading">
        <h4><i class="glyphicon glyphicon-file"></i> <?= Yii::t('app', 'Product Sources') ?>
            <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
            <button type="button" class="add-item-sources btn btn-info btn-sm pull-right"><i
                    class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>

        </h4>
    </div>
    <div class="panel-body">
        <div class="container-items-sources"><!-- widgetContainer -->
            <?php foreach ($modelSources as $i => $modelSource): ?>
                <div class="item-sources panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">

                        <h3 class="panel-title pull-left"><?= Yii::t('app', 'Source') ?></h3>
                        <div class="pull-right">
                            <button type="button" class="add-item-sources btn btn-info btn-xs"><i
                                    class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item-sources btn btn-danger btn-xs"><i
                                    class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.

                        echo Html::activeHiddenInput($modelSource, "[{$i}]id");

                        echo $form->field($modelSource, "[{$i}]product_id")->hiddenInput(['value' => $model->id])->label(false);
                        ?>
                        <div class="row">
                            <div class="col-sm-12">

                            </div>
                            <div class="col-sm-12">

                            </div>
                            <div class="col-sm-12">

                            </div>
                            <div class="col-sm-12">



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
