<?php

use yii\widgets\ActiveForm;

\kartik\datetime\DateTimePickerAsset::register($this);

?>
<?php

?>


<?php
if (Yii::$app->session->hasFlash('error')) {
    echo '<p class="has-error flashes"><span class="help-block help-block-error">' . Yii::$app->session->getFlash('error') . '</span></p>';
} elseif (Yii::$app->session->hasFlash('success')) {
    echo '<p class="has-success flashes"><span class="help-block help-block-success">' . Yii::$app->session->getFlash('success') . '</span></p>';
}
?>

<ul class="nav nav-pills nav-fill">
    <li class="nav-item">
        <a class="nav-link active"
           href="#content"
           data-toggle="tab"><?= Yii::t('app', 'Details') ?></a>
    </li>
<!--    <li class="nav-item">-->
<!--        <a class="nav-link"-->
<!--           href="#meta"-->
<!--           data-toggle="tab">--><?//= Yii::t('app', 'Meta') ?><!--</a>-->
<!--    </li>-->
    <li class="nav-item">
        <a class="nav-link"
           href="#prices"
           data-toggle="tab"><?= Yii::t('app', '$Prices') ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
           href="#sources"
           data-toggle="tab"><?= Yii::t('app', 'Sources') ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
           href="#times"
           data-toggle="tab"><?= Yii::t('app', 'Times') ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
           href="#add-ons"
           data-toggle="tab"><?= Yii::t('app', 'Add-ons') ?></a>
    </li>
<!--    <li class="nav-item">-->
<!--        <a class="nav-link"-->
<!--           href="#timetable"-->
<!--           data-toggle="tab">--><?//= Yii::t('app', 'TimeTable') ?><!--</a>-->
<!--    </li>-->
</ul>


<div class="tab-content">

    <div class="tab-pane active"
         id="content">

        <?= $this->render("forms/content", [
            "form" => $form,
            "model" => $model,
        ]); ?>

    </div>

    <div class="tab-pane"
         id="meta">

        <?= $this->render("forms/meta", [
            "form" => $form,
            "model" => $model,
        ]); ?>

    </div>

    <div class="tab-pane"
         id="prices">

        <?= $this->render("forms/prices", [
            "form" => $form,
            "model" => $model,
            "modelPrices" => $modelPrices
        ]); ?>

    </div>

    <div class="tab-pane"
         id="times">

        <?= $this->render("forms/times", [
            "form" => $form,
            "model" => $model,
            "modelTimes" => $modelTimes
        ]); ?>

    </div>

    <div class="tab-pane"
         id="sources">

        <?= $this->render("forms/sources", [
            "form" => $form,
            "model" => $model,
            "modelSources" => $modelSources
        ]); ?>

    </div>

    <div class="tab-pane"
         id="add-ons">
        <?= $this->render("forms/add-ons", [
            "form" => $form,
            "model" => $model,
            "prodId" => $prodId,
            "modelAddOns" => $modelAddOns,
            "selectedModelAddOns" => $selectedModelAddOns,
        ]); ?>
    </div>

    <div class="tab-pane"
         id="timetable">

        <?= $this->render("forms/timetable", [
            "form" => $form,
            "model" => $model,
            "prodId" => $prodId,
            "modelEvents" => $modelEvents
        ]); ?>

    </div>

    <?php
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

</div>
