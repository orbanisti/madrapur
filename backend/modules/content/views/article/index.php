<?php

use common\grid\EnumColumn;
use common\models\Article;
use common\models\ArticleCategory;
    use kartik\icons\Icon;
    use trntv\yii\datetime\DateTimeWidget;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 *
 * @var $this yii\web\View
 * @var $searchModel backend\modules\content\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */


?>




<div class="container">
    <div class="row">

        <div class="col-lg-12">



            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        <?=Yii::t('backend', 'Articles')?>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <p>
                        <?php

                            echo Html::a(Yii::t('backend', 'Create {modelClass} '.Icon::show('edit'), [
                                'modelClass' => 'Article'
                            ]), [
                                'create'
                            ], [
                                'class' => 'btn btn-info'
                            ]) ?>
                    </p>

                    <?php

                        echo GridView::widget(
                            [
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'options' => [
                                    'class' => 'grid-view table-responsive',
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'id',
                                        'options' => [
                                            'style' => 'width: 5%'
                                        ],
                                    ],
                                    [
                                        'attribute' => 'slug',
                                        'options' => [
                                            'style' => 'width: 15%'
                                        ],
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'value' => function ($model) {
                                            return Html::a($model->title, [
                                                'update',
                                                'id' => $model->id
                                            ]);
                                        },
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'category_id',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'value' => function ($model) {
                                            return $model->category ? $model->category->title : null;
                                        },
                                        'filter' => ArrayHelper::map(ArticleCategory::find()->all(), 'id', 'title'),
                                    ],
                                    [
                                        'attribute' => 'created_by',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'value' => function ($model) {
                                            return $model->author->username;
                                        },
                                    ],
                                    [
                                        'class' => EnumColumn::class,
                                        'attribute' => 'status',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'enum' => Article::statuses(),
                                        'filter' => Article::statuses(),
                                    ],
                                    [
                                        'attribute' => 'published_at',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'format' => 'datetime',
                                        'filter' => DateTimeWidget::widget(
                                            [
                                                'model' => $searchModel,
                                                'attribute' => 'published_at',
                                                'phpDatetimeFormat' => 'dd.MM.yyyy',
                                                'momentDatetimeFormat' => 'DD.MM.YYYY',
                                                'clientEvents' => [
                                                    'dp.change' => new JsExpression(
                                                        '(e) => $(e.target).find("input").trigger("change.yiiGridView")'),
                                                ],
                                            ]),
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'format' => 'datetime',
                                        'filter' => DateTimeWidget::widget(
                                            [
                                                'model' => $searchModel,
                                                'attribute' => 'created_at',
                                                'phpDatetimeFormat' => 'dd.MM.yyyy',
                                                'momentDatetimeFormat' => 'DD.MM.YYYY',
                                                'clientEvents' => [
                                                    'dp.change' => new JsExpression(
                                                        '(e) => $(e.target).find("input").trigger("change.yiiGridView")'),
                                                ],
                                            ]),
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'options' => [
                                            'style' => 'width: 5%'
                                        ],
                                        'template' => '{update} {delete}',
                                    ],
                                ],
                            ]);
                    ?>





                </div>
                <!-- /.card-body-->
            </div>
        </div>

    </div>
</div>

