<?php

use common\grid\EnumColumn;
use common\models\ArticleCategory;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 *
 * @var $this yii\web\View
 * @var $searchModel backend\modules\content\models\search\ArticleCategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model ArticleCategory
 * @var $categories common\models\ArticleCategory[]
 */



?>



<div class="container">
    <div class="row">
        <div class="col-lg-3">


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>  <?php echo Yii::t('backend', 'Create Article Category');?>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">



                            <?php

                                echo $this->render('_form', [
                                    'model' => $model,
                                    'categories' => $categories,
                                ]) ?>

                    </div>


                </div>
                <!-- /.card-body-->
            </div>


        <div class="col-lg-9">



            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        <?=Yii::t('backend', 'Email templates')?>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">




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
                                        'class' => EnumColumn::class,
                                        'attribute' => 'status',
                                        'options' => [
                                            'style' => 'width: 10%'
                                        ],
                                        'enum' => ArticleCategory::statuses(),
                                        'filter' => ArticleCategory::statuses(),
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

