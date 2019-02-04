<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Products\models\BlockoutsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tiltott időpontok');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="myproducts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Új időpont tiltás'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            /*'start_date',
            'end_date',*/
            [
                'attribute' => 'product_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->product->name, $model->product->url, ['class'=>'pn-block product-name']);
                },
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
