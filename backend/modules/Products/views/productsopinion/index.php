<?php



use yii\helpers\Html;

use yii\grid\GridViewbackend\



/* @var $this yii\web\View */

/* @var $searchModel app\modules\Products\models\ProductsopinionSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Vélemények');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="myproducts-index">



    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= (Yii::$app->session->getFlash('success'))?'<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>':''; ?>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        //'filterModel' => $searchModel,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



            [

                'attribute' => 'product_id',

                'format' => 'raw',

                'value' => function ($model) {

                    return Html::a($model->product->name, $model->product->url, ['class'=>'product-name']);

                },

            ],

            [

                'attribute' => 'user_id',

                //'format' => 'raw',

                'value' => function ($model) {

                    return $model->user->username;

                },

            ],

            'rating',



            [

                'attribute' =>  'comment',

                'contentOptions' => ['class' => 'hidden-comment'],

                'headerOptions' => ['class' => 'hidden-comment'],



            ],



            /*[

                'class' => 'yii\grid\ActionColumn',

                'template' => '{delete}',

                'buttons' => [

                    'delete' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/products/productsopinion/deleteinlist', 'id'=>$model->id], [

                                    'title' => Yii::t('app', 'Törlés'),

                                    'data-confirm' => Yii::t('app', 'Biztos benne, hogy törli ezt az elemet?'),                                  

                        ]);

                    },

                ],

            ],*/

            [

                'attribute' =>  'comment',

                'headerOptions' => ['class' => 'hidden'],

                'contentOptions' => ['class' => 'popinion'],

            ],

        ],

    ]); ?>



</div>

