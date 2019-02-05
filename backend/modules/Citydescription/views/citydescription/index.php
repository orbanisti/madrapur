<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\extra;

$this->title = Yii::t('app', 'Városok');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="citydescription-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Új város'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'title',
            //'link',
            [
            'attribute' => 'content',
                'format' => 'raw',
                'value' => function ($model) {
                    return extra::getIntro($model->content,150);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createAbsoluteUrl(['/../citydescription/citydescription/view', 'id'=>$model->id, 'title'=>$model->link]));
                    },
                    /*'link' => function ($url,$model,$key) {
                            return Html::a('Action', $url);
                    },*/
                ],
            ],
        ],
    ]); ?>

</div>

