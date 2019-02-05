<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\modules\Users\Module as Usermodule;
use backend\modules\Products\models\Products;
use backend\modules\Products\models\Productsprice;
use backend\modules\Products\models\ProductsTime;
use lajax\translatemanager\models\Language;
use backend\modules\Products\models\Productstranslate;

$model = new Products();
$modelTranslations = [];
foreach (Language::getLanguages() as $language) {
    if($language->language_id!=$model->lang_code) {
        $langId=$language->language_id;
        $translation = new Productstranslate;
        $translation->product_id = $model->id;
        $translation->lang_code = $langId;
        $modelTranslations[] = $translation;
    }
}

echo $this->render('_form_info', [
    'model' => $model,
    'modelTranslations' => $modelTranslations,
    'modelPrices' => [new Productsprice],
    'modelTimes' => [new ProductsTime],
]);

$loguser=Usermodule::getLogineduser();
if($loguser->agree_upload_info==0 && !Yii::$app->getModule('users')->isAdmin()) {
    
    $agrreform = new \yii\base\DynamicModel([
        'agree'
    ]);

    $agrreform->addRule('agree', 'required', ['requiredValue' => 1, 'message' => Yii::t('app','El kell fogadnod a feltölési feltételeket.')])->validate();

    $form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]);
    ?>

    <?= $form->field($agrreform, 'agree')->checkbox(['checked' => false, 'label' => null])->label(Yii::t('app','Elolvastam a tájékoztatót és elfogadom a feltölési feltételeket.')); ?>

    <?= Html::submitButton(Yii::t('app','Tovább a feltöltésre')) ?>

    <?php ActiveForm::end(); ?>

<?php } ?>