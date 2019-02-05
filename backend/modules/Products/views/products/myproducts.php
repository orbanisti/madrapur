<?php


use yii\helpers\Html;

use yii\grid\GridView;

use backend\components\extra;

use \backend\modules\Products\models\Products;

use backend\modules\Products\models\Productscategory;

use yii\widgets\Pjax;



/* @var $this yii\web\View */

/* @var $searchModel backend\modules\Products\models\ProductsSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Termékeim');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="myproducts-index">



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="pull-left hidden-sm hidden-md hidden-lg hidden-print">

        <?php echo '<form class="gwform"><input class="gwinput" placeholder="'.Yii::t('app','keresés').'" class="form-control" name="ProductsSearch[search]" value="'. $searchModel['search'] .'" type="text"><input class="gwsubmit" type="submit" value=""></form>'; ?>

    </div>

    <p>

        <?= Html::a(Yii::t('app', 'Termék létrehozása'), ['create'], ['class' => 'btn btn-create-product pull-right']) ?>

    </p>

<?php //Pjax::begin(); ?>

    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        //'filterModel' => $searchModel,

        'layout' => "{items}\n{pager}",

        'columns' => [

            //['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'image',

                'format' => 'raw',

                'contentOptions' => ['class' => 'myprod-pic-th'],

                'headerOptions' => ['class' => 'myprod-pic-th'],

                'value' => function ($model) {                      

                    return Html::a(Html::img($model->smallthumb), $model->url);

                },

            ],

            ['attribute' => 'name',

                'format' => 'raw',

                'headerOptions' => ['class' => 'myprod-name-th'],

                'value' => function ($model) {                      

                    return Html::a($model->name, $model->url, ['class'=>'product-name']);

                },

            ],

            ['attribute' => 'intro',

                'format' => 'raw',

                'contentOptions' => ['class' => 'myprod-intro-th'],

                'headerOptions' => ['class' => 'myprod-intro-th'],

                'value' => function ($model) {                      

                    return extra::getIntro($model->intro);

                },

            ],

            /*['attribute' => 'description',

                'format' => 'raw',

                'value' => function ($model) {                      

                    return extra::getIntro($model->description);

                },

            ],*/

            ['attribute' => 'status',

                'value' => function ($model) {                      

                        return Products::status($model->status);

                },

                'filter' => Html::activeDropDownList($searchModel, 'status', Products::status(),['class'=>'form-control','prompt' => '']),

            ],

            ['attribute' => 'category_id',

                'value' => function ($model) {                      

                        return $model->category->name;

                },

                'filter' => Html::activeDropDownList($searchModel, 'category_id', Products::getDropdowncategories(),['class'=>'form-control','prompt' => '']),

            ],

            [

                'class' => 'yii\grid\ActionColumn',

                'header' => '<form class="gwform"><input class="gwinput" placeholder="'.Yii::t('app','keresés').'" class="form-control" name="ProductsSearch[search]" value="'. $searchModel['search'] .'" type="text"><input class="gwsubmit" type="submit" value=""></form>',

                'template' => '{view} {update} {delete}',    

            ],

        ],

    ]); ?>

<?php //Pjax::end(); ?>

</div>

