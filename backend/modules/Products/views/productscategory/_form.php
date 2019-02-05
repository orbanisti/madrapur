<?php



use yii\helpers\Html;


use yii\widgetsbackend\iveForm;


use \backend\modules\Products\models\Productscategory;


use lajax\translatemanager\models\Language;


use kartik\select2\Select2;





/* @var $this yii\web\View */


/* @var $model backend\modules\Products\models\Productscategory */


/* @var $form yii\widgets\ActiveForm */


?>





<div class="productscategory-form">





        <?php $form = ActiveForm::begin([


        //'enableClientValidation' => false


        'id' => 'prodcat-form',


        ]); ?>


    


    <ul class="nav nav-tabs">


        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>


        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>


    </ul>


    


    <div class="tab-content">


        <div class="tab-pane active" id="content">


            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


            


            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [


                'data' => Productscategory::getParentslisttoadmin(),


                'options' => [


                    'placeholder' => '',


                ],


                'pluginOptions' => [


                    'tags' => false,


                    'multiple' => false,


                ],


            ]) ?>





            <?= $form->field($model, 'intro')->textarea(['maxlength' => true]) ?>





            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>





            <?= $form->field($model, 'status')->dropDownList(Productscategory::status()); ?>


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


                /*$first=true;


                foreach ($modelTranslations as $langId=>$translation) {


                    $language=Language::findOne(['language_id'=>$translation->lang_code]);


                    $langId=$language->language_id;


                    $liclass=($first)?' class="active"':''; $first=false;


                    echo '<li'.$liclass.'><a href="#'.$langId.'" data-toggle="tab">'.$language->name.'</a></li>';


                    


                }*/


                ?>


            </ul>


            


            <div class="tab-content">





                


                <?php 


                //$first=true;


                foreach ($modelTranslations as $langId=>$translation) {


                //$liclass=($first)?' active':''; $first=false;    


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





    <div class="form-group">


        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>


    </div>





    <?php ActiveForm::end(); ?>





</div>


