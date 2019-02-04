<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\Products\models\Graylinepartners;

$this->title = Yii::t('app', 'Grayline partnerek');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graylinepartners-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Új partner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'pager' => [
            'firstPageLabel' => Yii::t('app','Első oldal'),
            'lastPageLabel'  => Yii::t('app','Utolsó oldal'),
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'channel',
            'description',
            'link',
            ['attribute' => 'status',
                'value' => function ($model) {
                        return Graylinepartners::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Graylinepartners::status(),['class'=>'form-control','prompt' => '']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
