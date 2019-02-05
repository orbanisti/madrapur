<?phpbackend\

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zxbodya\yii2\imageAttachment\ImageAttachmentWidget;
use kartik\file\FileInput;
use app\modules\Users\Module as Usermodule;

$this->title = $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-view">

    <h1><?= Yii::t('app','Profilom szerkesztése'). ': "'.Html::encode($this->title).'"' ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'profile-form',
        'options' => ['enctype'=>'multipart/form-data', 'class' => 'mandelan-form form-horizontal'],
        'fieldConfig' => [
           /* 'template' => "<div class=\"row\">{input}</div>\n<div class=\"row\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],*/
        ],
    ]); ?>

    <?= ImageAttachmentWidget::widget(
        [
            'model' => $model,
            'behaviorName' => 'coverBehavior',
            'apiRoute' => 'profile/imgAttachApi',
        ]
    ) ?>
    
    <?php
    $hint='';
    if($model->user->type==Usermodule::TYPE_PARTNER) {
        $hint=Yii::t('app','kapcsolattartó');
        ?>
    
        <?php /*$form->field($model, 'logo')->widget(FileInput::classname(), [
            'options'=>['accept'=>'image/*'],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false]
        ])*/ ?>
    
        <?= $form->field($model, 'logo')->fileInput() ?>
        <?= (!$model->isNewRecord && $model->logo!='')?Html::img(Yii::$app->params['logoPictures'] . $model->logo,['style'=>'max-width: 300px;']).'<br/><br/>':'' ?>

        <?= $form->field($model, 'company_name') ?>
    
        <?= $form->field($model, 'email')->hint(Yii::t('app','Ha eltér a regisztrációnál használttól')) ?>
    
        <?= $form->field($model, 'tax_code') ?>

        <?= $form->field($model, 'bank_acc_number') ?>

        <?= $form->field($model, 'reg_code') ?>

    <?php } ?>

    <?= $form->field($model, 'last_name')->hint($hint) ?>

    <?= $form->field($model, 'first_name')->hint($hint) ?>

    <?= $form->field($model, 'phone')->hint($hint) ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'zipcode') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'about')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Módosítás'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

