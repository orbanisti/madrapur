<?php

?>



<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fab fa-google fa-lg fa-fw"></i>
                    Seo Manager
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">


                <div id="currentType">
                    <?php

                        use common\models\Article;
                        use common\models\ArticleCategory;
                        use kartik\grid\EnumColumn;
                        use kartik\grid\GridView;
                        use kartik\helpers\Html;
                        use yii\helpers\ArrayHelper;

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
                                        'class' => 'kartik\grid\ActionColumn',
                                        'options' => [
                                            'style' => 'width: 5%'
                                        ],
                                        'template' => '{update} {delete}',
                                    ],
                                ],
                            ]);
                    ?>

                </div>
               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>
