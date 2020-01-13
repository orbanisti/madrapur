<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-search fa-fw "></i>

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-lg-4">
                        <!-- interactive chart -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="far fa-chart-bar"></i>
                                    Create New
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="card-body">
                                <?php use backend\modules\Seo\models\Seoproject;
                                    use kartik\widgets\ActiveForm;
                                    use yii\bootstrap4\Html;
                                    use yii\data\ActiveDataProvider;

                                    $form = ActiveForm::begin();


                                    echo $form->field(new Seoproject,'domain');

                                ?>

                                <div class="form-group">
                                    <?php echo Html::submitButton(Yii::t('frontend', 'Add'), ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end() ?>

                            </div>
                            <!-- /.card-body-->
                        </div>
                        <!-- /.card -->

                    </div>
                    <div class="col-lg-8">
                            <!-- interactive chart -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="far fa-chart-bar"></i>
                                        Seo Projects
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div id="seoprojects" class="card-body">
                                    <?php

                                        $projects=Seoproject::find();
                                        $projectsDataProvider = new ActiveDataProvider([
                                                                                   'query' => $projects,
                                                                                   'pagination' => [
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

                    <!-- /.col -->
                </div>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>