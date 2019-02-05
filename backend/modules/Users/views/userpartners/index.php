<?php



use backend\helpers\Html;

use yii\grid\GridView;
backend\
use app\modules\Users\models\Userpartners;



/* @var $this yii\web\View */

/* @var $searchModel app\modules\Users\models\UserpartnersSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Partnereim');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="products-index">



    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <p>

        <?= Html::a(Yii::t('app', 'Új partner'), ['create'], ['class' => 'btn btn-success']) ?>

    </p>



    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        //'filterModel' => $searchModel,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



            [

                'attribute' => 'partner_id',

                'value' =>  function ($model) {

                    return $model->partner->username;

                }

            ],

            [

                'attribute' => 'rights',

                'value' => function ($model) {                      

                        return Userpartners::rights($model->rights);

                },

            ],

                        

            [

                'class' => 'yii\grid\ActionColumn',

                'template' => '{update} {delete}'

            ],

        ],

    ]); ?>



</div>

