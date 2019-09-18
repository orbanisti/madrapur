[1mdiff --git a/backend/modules/Products/views/blockouts/_search.php b/backend/modules/Products/views/blockouts/_search.php[m
[1mindex 30c84fb..21fda46 100644[m
[1m--- a/backend/modules/Products/views/blockouts/_search.php[m
[1m+++ b/backend/modules/Products/views/blockouts/_search.php[m
[36m@@ -1,33 +1,33 @@[m
[31m-<?php[m
[31m-[m
[31m-use yii\helpers\Html;[m
[31m-use yii\widgets\ActiveForm;[m
[31m-[m
[31m-/* @var $this yii\web\View */[m
[31m-/* @var $model app\modules\Products\models\BlockoutsSearch */[m
[31m-/* @var $form yii\widgets\ActiveForm */[m
[31m-?>[m
[31m-[m
[31m-<div class="blockouts-search">[m
[31m-[m
[31m-    <?php $form = ActiveForm::begin([[m
[31m-        'action' => ['index'],[m
[31m-        'method' => 'get',[m
[31m-    ]); ?>[m
[31m-[m
[31m-    <?= $form->field($model, 'id') ?>[m
[31m-[m
[31m-    <?= $form->field($model, 'start_date') ?>[m
[31m-[m
[31m-    <?= $form->field($model, 'end_date') ?>[m
[31m-[m
[31m-    <?= $form->field($model, 'product_id') ?>[m
[31m-[m
[31m-    <div class="form-group">[m
[31m-        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>[m
[31m-        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>[m
[31m-    </div>[m
[31m-[m
[31m-    <?php ActiveForm::end(); ?>[m
[31m-[m
[31m-</div>[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32muse yii\helpers\Html;[m
[32m+[m[32muse yii\widgets\ActiveForm;[m
[32m+[m
[32m+[m[32m/* @var $this yii\web\View */[m
[32m+[m[32m/* @var $model app\modules\Products\models\BlockoutsSearch */[m
[32m+[m[32m/* @var $form yii\widgets\ActiveForm */[m
[32m+[m[32m?>[m
[32m+[m
[32m+[m[32m<div class="blockouts-search">[m
[32m+[m
[32m+[m[32m    <?php $form = ActiveForm::begin([[m
[32m+[m[32m        'action' => ['index'],[m
[32m+[m[32m        'method' => 'get',[m
[32m+[m[32m    ]); ?>[m
[32m+[m
[32m+[m[32m    <?= $form->field($model, 'id') ?>[m
[32m+[m
[32m+[m[32m    <?= $form->field($model, 'start_date') ?>[m
[32m+[m
[32m+[m[32m    <?= $form->field($model, 'end_date') ?>[m
[32m+[m
[32m+[m[32m    <?= $form->field($model, 'product_id') ?>[m
[32m+[m
[32m+[m[32m    <div class="form-group">[m
[32m+[m[32m        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>[m
[32m+[m[32m        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m[32m    <?php ActiveForm::end(); ?>[m
[32m+[m
[32m+[m[32m</div>[m
[1mdiff --git a/backend/modules/Products/views/blockouts/create.php b/backend/modules/Products/views/blockouts/create.php[m
[1mindex c648c4e..e105bf9 100644[m
[1m--- a/backend/modules/Products/views/blockouts/create.php[m
[1m+++ b/backend/modules/Products/views/blockouts/create.php[m
[36m@@ -1,19 +1,19 @@[m
[31m-<?php[m
[31m-[m
[31m-use yii\helpers\Html;[m
[31m-[m
[31m-[m
[31m-/* @var $this yii\web\View */[m
[31m-/* @var $model app\modules\Products\models\Blockouts */[m
[31m-[m
[31m-$this->title = Yii::t('app', 'Új időpont tíltás');[m
[31m-?>[m
[31m-<div class="blockouts-create">[m
[31m-[m
[31m-    <h1><?= Html::encode($this->title) ?></h1>[m
[31m-[m
[31m-    <?= $this->render('_form', [[m
[31m-        'model' => $model,[m
[31m-    ]) ?>[m
[31m-[m
[31m-</div>[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32muse yii\helpers\Html;[m
[32m+[m
[32m+[m
[32m+[m[32m/* @var $this yii\web\View */[m
[32m+[m[32m/* @var $model app\modules\Products\models\Blockouts */[m
[32m+[m
[32m+[m[32m$this->title = Yii::t('app', 'Új időpont tíltás');[m
[32m+[m[32m?>[m
[32m+[m[32m<div class="blockouts-create">[m
[32m+[m
[32m+[m[32m    <h1><?= Html::encode($this->title) ?></h1>[m
[32m+[m
[32m+[m[32m    <?= $this->render('_form', [[m
[32m+[m[32m        'model' => $model,[m
[32m+[m[32m    ]) ?>[m
[32m+[m
[32m+[m[32m</div>[m
[1mdiff --git a/backend/modules/Products/views/blockouts/index.php b/backend/modules/Products/views/blockouts/index.php[m
[1mindex cefb946..5cd33ca 100644[m
[1m--- a/backend/modules/Products/views/blockouts/index.php[m
[1m+++ b/backend/modules/Products/views/blockouts/index.php[m
[36m@@ -1,45 +1,45 @@[m
[31m-<?php
[m
[31m-
[m
[31m-use yii\helpers\Html;
[m
[31m-use yii\grid\GridView;
[m
[31m-
[m
[31m-/* @var $this yii\web\View */
[m
[31m-/* @var $searchModel app\modules\Products\models\BlockoutsSearch */
[m
[31m-/* @var $dataProvider yii\data\ActiveDataProvider */
[m
[31m-
[m
[31m-$this->title = Yii::t('app', 'Tiltott időpontok');
[m
[31m-$this->params['breadcrumbs'][] = $this->title;
[m
[31m-?>
[m
[31m-<div class="myproducts-index">
[m
[31m-
[m
[31m-    <h1><?= Html::encode($this->title) ?></h1>
[m
[31m-    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
[m
[31m-
[m
[31m-    <p>
[m
[31m-        <?= Html::a(Yii::t('app', 'Új időpont tiltás'), ['create'], ['class' => 'btn btn-info']) ?>
[m
[31m-    </p>
[m
[31m-
[m
[31m-    <?= GridView::widget([
[m
[31m-        'dataProvider' => $dataProvider,
[m
[31m-        //'filterModel' => $searchModel,
[m
[31m-        'columns' => [
[m
[31m-            ['class' => 'yii\grid\SerialColumn'],
[m
[31m-
[m
[31m-            /*'start_date',
[m
[31m-            'end_date',*/
[m
[31m-            [
[m
[31m-                'attribute' => 'product_id',
[m
[31m-                'format' => 'raw',
[m
[31m-                'value' => function ($model) {
[m
[31m-                    return Html::a($model->product->name, $model->product->url, ['class'=>'pn-block product-name']);
[m
[31m-                },
[m
[31m-            ],
[m
[31m-            
[m
[31m-            [
[m
[31m-                'class' => 'yii\grid\ActionColumn',
[m
[31m-                'template' => '{update} {delete}',
[m
[31m-            ],
[m
[31m-        ],
[m
[31m-    ]); ?>
[m
[31m-
[m
[31m-</div>
[m
[32m+[m[32m<?php[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32muse yii\helpers\Html;[m[41m
[m
[32m+[m[32muse yii\grid\GridView;[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m/* @var $this yii\web\View */[m[41m
[m
[32m+[m[32m/* @var $searchModel app\modules\Products\models\BlockoutsSearch */[m[41m
[m
[32m+[m[32m/* @var $dataProvider yii\data\ActiveDataProvider */[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m$this->title = Yii::t('app', 'Tiltott időpontok');[m[41m
[m
[32m+[m[32m$this->params['breadcrumbs'][] = $this->title;[m[41m
[m
[32m+[m[32m?>[m[41m
[m
[32m+[m[32m<div class="myproducts-index">[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m    <h1><?= Html::encode($this->title) ?></h1>[m[41m
[m
[32m+[m[32m    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m    <p>[m[41m
[m
[32m+[m[32m        <?= Html::a(Yii::t('app', 'Új időpont tiltás'), ['create'], ['class' => 'btn btn-info']) ?>[m[41m
[m
[32m+[m[32m    </p>[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m    <?= GridView::widget([[m[41m
[m
[32m+[m[32m        'dataProvider' => $dataProvider,[m[41m
[m
[32m+[m[32m        //'filterModel' => $searchModel,[m[41m
[m
[32m+[m[32m        'columns' => [[m[41m
[m
[32m+[m[32m            ['class' => 'yii\grid\SerialColumn'],[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m            /*'start_date',[m[41m
[m
[32m+[m[32m            'end_date',*/[m[41m
[m
[32m+[m[32m            [[m[41m
[m
[32m+[m[32m                'attribute' => 'product_id',[m[41m
[m
[32m+[m[32m                'format' => 'raw',[m[41m
[m
[32m+[m[32m                'value' => function ($model) {[m[41m
[m
[32m+[m[32m                    return Html::a($model->product->name, $model->product->url, ['class'=>'pn-block product-name']);[m[41m
[m
[32m+[m[32m                },[m[41m
[m
[32m+[m[32m            ],[m[41m
[m
[32m+[m[41m            
[m
[32m+[m[32m            [[m[41m
[m
[32m+[m[32m                'class' => 'yii\grid\ActionColumn',[m[41m
[m
[32m+[m[32m                'template' => '{update} {delete}',[m[41m
[m
[32m+[m[32m            ],[m[41m
[m
[32m+[m[32m        ],[m[41m
[m
[32m+[m[32m    ]); ?>[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m</div>[m[41m
[m
[1mdiff --git a/backend/modules/Products/views/blockouts/update.php b/backend/modules/Products/views/blockouts/update.php[m
[1mindex 7a43af7..acf7b88 100644[m
[1m--- a/backend/modules/Products/views/blockouts/update.php[m
[1m+++ b/backend/modules/Products/views/blockouts/update.php[m
[36m@@ -1,18 +1,18 @@[m
[31m-<?php[m
[31m-[m
[31m-use yii\helpers\Html;[m
[31m-[m
[31m-/* @var $this yii\web\View */[m
[31m-/* @var $model app\modules\Products\models\Blockouts */[m
[31m-[m
[31m-$this->title = Yii::t('app', 'Időpont tíltás módosítása');[m
[31m-?>[m
[31m-<div class="blockouts-update">[m
[31m-[m
[31m-    <h1><?= Html::encode($this->title) ?></h1>[m
[31m-[m
[31m-    <?= $this->render('_form', [[m
[31m-        'model' => $model,[m
[31m-    ]) ?>[m
[31m-[m
[31m-</div>[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32muse yii\helpers\Html;[m
[32m+[m
[32m+[m[32m/* @var $this yii\web\View */[m
[32m+[m[32m/* @var $model app\modules\Products\models\Blockouts */[m
[32m+[m
[32m+[m[32m$this->title = Yii::t('app', 'Időpont tíltás módosítása');[m
[32m+[m[32m?>[m
[32m+[m[32m<div class="blockouts-update">[m
[32m+[m
[32m+[m[32m    <h1><?= Html::encode($this->title) ?></h1>[m
[32m+[m
[32m+[m[32m    <?= $this->render('_form', [[m
[32m+[m[32m        'model' => $model,[m
[32m+[m[32m    ]) ?>[m
[32m+[m
[32m+[m[32m</div>[m
[1mdiff --git a/backend/modules/Products/views/blockouts/view.php b/backend/modules/Products/views/blockouts/view.php[m
[1mindex 58d6720..544cd20 100644[m
[1m--- a/backend/modules/Products/views/blockouts/view.php[m
[1m+++ b/backend/modules/Products/views/blockouts/view.php[m
[36m@@ -1,38 +1,38 @@[m
[31m-<?php[m
[31m-[m
[31m-use yii\helpers\Html;[m
[31m-use yii\widgets\DetailView;[m
[31m-[m
[31m-/* @var $this yii\web\View */[m
[31m-/* @var $model app\modules\Products\models\Blockouts */[m
[31m-[m
[31m-$this->title = $model->id;[m
[31m-$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blockouts'), 'url' => ['index']];[m
[31m-$this->params['breadcrumbs'][] = $this->title;[m
[31m-?>[m
[31m-<div class="blockouts-view">[m
[31m-[m
[31m-    <h1><?= Html::encode($this->title) ?></h1>[m
[31m-[m
[31m-    <p>[m
[31m-        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>[m
[31m-        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [[m
[31m-            'class' => 'btn btn-danger',[m
[31m-            'data' => [[m
[31m-                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),[m
[31m-                'method' => 'post',[m
[31m-            ],[m
[31m-        ]) ?>[m
[31m-    </p>[m
[31m-[m
[31m-    <?= DetailView::widget([[m
[31m-        'model' => $model,[m
[31m-        'attributes' => [[m
[31m-            'id',[m
[31m-            'start_date',[m
[31m-            'end_date',[m
[31m-            'product_id',[m
[31m-        ],[m
[31m-    ]) ?>[m
[31m-[m
[31m-</div>[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32muse yii\helpers\Html;[m
[32m+[m[32muse yii\widgets\DetailView;[m
[32m+[m
[32m+[m[32m/* @var $this yii\web\View */[m
[32m+[m[32m/* @var $model app\modules\Products\models\Blockouts */[m
[32m+[m
[32m+[m[32m$this->title = $model->id;[m
[32m+[m[32m$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blockouts'), 'url' => ['index']];[m
[32m+[m[32m$this->params['breadcrumbs'][] = $this->title;[m
[32m+[m[32m?>[m
[32m+[m[32m<div class="blockouts-view">[m
[32m+[m
[32m+[m[32m    <h1><?= Html::encode($this->title) ?></h1>[m
[32m+[m
[32m+[m[32m    <p>[m
[32m+[m[32m        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>[m
[32m+[m[32m        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [[m
[32m+[m[32m            'class' => 'btn btn-danger',[m
[32m+[m[32m            'data' => [[m
[32m+[m[32m                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),[m
[32m+[m[32m                'method' => 'post',[m
[32m+[m[32m            ],[m
[32m+[m[32m        ]) ?>[m
[32m+[m[32m    </p>[m
[32m+[m
[32m+[m[32m    <?= DetailView::widget([[m
[32m+[m[32m        'model' => $model,[m
[32m+[m[32m        'attributes' => [[m
[32m+[m[32m            'id',[m
[32m+[m[32m            'start_date',[m
[32m+[m[32m            'end_date',[m
[32m+[m[32m            'product_id',[m
[32m+[m[32m        ],[m
[32m+[m[32m    ]) ?>[m
[32m+[m
[32m+[m[32m</div>[m
[1mdiff --git a/backend/modules/Products/views/cities/_form.php b/backend/modules/Products/views/cities/_form.php[m
[1mindex 0f0a794..4ee9eaa 100644[m
[1m--- a/backend/modules/Products/views/cities/_form.php[m
[1m+++ b/backend/modules/Products/views/cities/_form.php[m
[36m@@ -1,83 +1,83 @@[m
[31m-<?php
[m
[31m-
[m
[31m-use yii\helpers\Html;
[m
[31m-use yii\widgets\ActiveForm;
[m
[31m-use lajax\translatemanager\models\Language;
[m
[31m-
[m
[31m-/* @var $this yii\web\View */
[m
[31m-/* @var $model app\modules\Products\models\Cities */
[m
[31m-/* @var $form yii\widgets\ActiveForm */
[m
[31m-?>
[m
[31m-
[m
[31m-<div class="cities-form">
[m
[31m-
[m
[31m-    <?php $form = ActiveForm::begin(); ?>
[m
[31m-
[m
[31m-    <ul class="nav nav-tabs">
[m
[31m-        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>
[m
[31m-        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>
[m
[31m-    </ul>
[m
[31m-    
[m
[31m-    <div class="tab-content">
[m
[31m-        <div class="tab-pane active" id="content">
[m
[31m-            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
[m
[31m-            
[m
[31m-            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
[m
[31m-        </div>
[m
[31m-        
[m
[31m-        <div class="tab-pane" id="translate">
[m
[31m-            
[m
[31m-            <ul class="nav nav-tabs">
[m
[31m-                <?php 
[m
[31m-                $first=true;
[m
[31m-                foreach (Language::getLanguages() as $language) {
[m
[31m-                    if($language->language_id!=Yii::$app->sourceLanguage) {
[m
[31m-                        $langId=$language->language_id;
[m
[31m-                        $liclass=($first)?' class="active"':'';
[m
[31m-                        if($first) $firstlang=$language->language_id;
[m
[31m-                        $first=false;
[m
[31m-                        echo '<li'.$liclass.'><a href="#'.$langId.'" data-toggle="tab">'.$language->name.'</a></li>';
[m
[31m-                    }
[m
[31m-                }
[m
[31m-                /*$first=true;
[m
[31m-                foreach ($modelTranslations as $langId=>$translation) {
[m
[31m-                    $language=Language::findOne(['language_id'=>$translation->lang_code]);
[m
[31m-                    $langId=$language->language_id;
[m
[31m-                    $liclass=($first)?' class="active"':''; $first=false;
[m
[31m-                    echo '<li'.$liclass.'><a href="#'.$langId.'" data-toggle="tab">'.$language->name.'</a></li>';
[m
[31m-                    
[m
[31m-                }*/
[m
[31m-                ?>
[m
[31m-            </ul>
[m
[31m-            
[m
[31m-            <div class="tab-content">
[m
[31m-
[m
[31m-                
[m
[31m-                <?php 
[m
[31m-                //$first=true;
[m
[31m-                foreach ($modelTranslations as $langId=>$translation) {
[m
[31m-                //$liclass=($first)?' active':''; $first=false;    
[m
[31m-                $liclass=($firstlang==$translation->lang_code)?' active':'';
[m
[31m-                ?>
[m
[31m-
[m
[31m-                <div class="tab-pane<?= $liclass ?>" id="<?= $translation->lang_code ?>">
[m
[31m-            
[m
[31m-                    <?= $form->field($translation, "[{$langId}]name")->textInput(['maxlength' => true]) ?>
[m
[31m-                    
[m
[31m-                    <?= $form->field($translation, "[{$langId}]country")->textInput(['maxlength' => true]) ?>
[m
[31m-                
[m
[31m-                </div>
[m
[31m-                
[m
[31m-                <?php } ?>
[m
[31m-                
[m
[31m-            </div>
[m
[31m-        </div>
[m
[31m-    </div>
[m
[31m-
[m
[31m-    <div class="form-group">
[m
[31m-        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Mentés') : Yii::t('app', 'Módosítás'), ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
[m
[31m-    </div>
[m
[31m-
[m
[31m-    <?php ActiveForm::end(); ?>
[m
[31m-
[m
[31m-</div>
[m
[32m+[m[32m<?php[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32muse yii\helpers\Html;[m[41m
[m
[32m+[m[32muse yii\widgets\ActiveForm;[m[41m
[m
[32m+[m[32muse lajax\translatemanager\models\Language;[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m/* @var $this yii\web\View */[m[41m
[m
[32m+[m[32m/* @var $model app\modules\Products\models\Cities */[m[41m
[m
[32m+[m[32m/* @var $form yii\widgets\ActiveForm */[m[41m
[m
[32m+[m[32m?>[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m<div class="cities-form">[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m    <?php $form = ActiveForm::begin(); ?>[m[41m
[m
[32m+[m[41m
[m
[32m+[m[32m    <ul class="nav nav-tabs">[m[41m
[m
[32m+[m[32m        <li class="active"><a href="#content" data-toggle="tab">Tartalom</a></li>[m[41m
[m
[32m+[m[32m        <li><a href="#translate" data-toggle="tab">Fordítás</a></li>[m[41m
[m
[32m+[m[32m    </ul>[m[41m
[m
[32m+[m[41m    
[m
[32m+[m[32m    <div class="tab-content">[m[41m
[m
[32m+[m[32m        <div class="tab-pane active" id="content">[m[41m
[m
[32m+[m[32m            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>[m[41m
[m
[32m+[m[41m            
[m
[32m+[m[32m            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>[m[41m
[m
[32m+[m[32m        </div>[m[41m
[m
[32m+[m[41m        
[m
[32m+[m[32m        <div class="tab-pane" id="translate">[m[41m
[m
[32m+[m[41m            
[m
[32m+[m[32m            <ul class="nav nav-tabs">[m[41m
[m
[32m+[m[32m                <?php[m[41m 
[m
[32m+[m[32m                $first=true;[m[41m
[m
[32m+[m[32m                foreach (Language::getLanguages() as $language) {[m[41m
[m
[32m+[m[32m                    if($language->language_id!=Yii::$app->sourceLanguage) {[m[41m
[m
[32m+[m[32m                        $langId=$language->language_id;[m[41m
[m
[32m+[m[32m                        $liclass=($first)?' class="active"':'';[m[41m
[m
[32m+[m[32m                        if($first) $firstlang=$language->language_id;[m[41m
[m
[32m+[m[32m                        $first=false;[m[41m
[m
[32m+[m[32m                        echo '<li'.$liclass.'><a href="#'.$langId.'" data-toggle="tab">'.$language->name.'</a></li>';[m[41m
[m
[32m+[m[32m                    }[m[41m
[m
[32m+[m[32m                }[m[41m
[m
[32m+[m[32m                /*$first=true;[m[41m
[m
[32m+[m[32m                foreach ($modelTranslations as $langId=>$translation) {[m[41m
[m
[32m+[m[32m                    $language=Language::findOne(['language_id'=>$translation->lang_code]);[m[41m
[m
[32m+[m[32m                    $langId=$language->language_id;[m