<?phpbackend\
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lajax\translatemanager\models\Language;
use app\modules\Products\models\Productscategory;
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>
        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="content">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php
            if($model->isNewRecord) {
                foreach (Productscategory::getCategorytochk() as $key=>$cat) {
                    $model->categorieslist[]=$key;
                }
            }
            ?>
            <?= $form->field($model, 'categorieslist')->checkboxList(Productscategory::getCategorytochk())->label(Yii::t('app', 'Kategóriák').'<br/>'.Html::checkbox('allservices', false, ['id'=>'allservices', 'label'=>Yii::t('app','Mind kijelöl')])) ?>
            <?php
            $this->registerJs('$("#allservices").change(function() {
                if($("#allservices").is(":checked")) {
                    $("#services-categorieslist input").each(function() {
                        $(this).prop("checked", true);
                    });
                } else {
                    $("#services-categorieslist input").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                });');
            ?>
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
                    <?= $form->field($translation, "[{$langId}]name")->textInput(['maxlength' => true]) ?>
                </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Mentés') : Yii::t('app', 'Módosítás'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>