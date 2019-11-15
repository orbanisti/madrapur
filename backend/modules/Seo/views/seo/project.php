<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-primary"><i
                                class="fas fa-circle fa-fw "></i></i>Fetch
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?php

                    use backend\modules\Seo\models\Seourl;
                    use yii\bootstrap4\Html;
                    use yii\data\ActiveDataProvider;

                    $currentProjectId=Yii::$app->request->get('id');

                    $projectUrls= Seourl::find()->andFilterWhere(['=','projectId',$currentProjectId]);
                    $projectsDataProvider = new ActiveDataProvider([
                                                                       'query' => $projectUrls,
                                       r                                'pagination' => [
                                                                           'pageSize' => 15,
                                                                       ],
                                                                   ]);


                    echo $projectGrid=\kartik\grid\GridView::widget(
                        [
                            'dataProvider' => $projectsDataProvider,
                            'columns' => [
                                [
                                    'label' => 'Domain',
                                    'attribute' => 'domain',

                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{project}',
                                    'buttons' => [
                                        'project' => function ($url) {
                                            return Html::a(
                                                '<i class="fas fa-eye fa-lg "></i>',
                                                $url,
                                                [
                                                    'title' => Yii::t('backend', 'View')
                                                ]
                                            );
                                        },

                                    ],

                                ],

                            ]


                        ]
                    );
                ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>