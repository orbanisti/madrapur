<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    SEO Editor
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?php

                    /**
                     * @var $this       yii\web\View
                     * @var $model      common\models\Article
                     * @var $categories common\models\ArticleCategory[]
                     */
                ?>

                <div class="row">
                    <div class="col-12">
                        <!-- interactive chart -->
                        <div class="card card-primary card-outline  collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-pen  "></i>
                                    <?=Yii::t('backend', 'Update {modelClass}: ', [
                                        'modelClass' => 'Article',
                                    ]) . ' ' . $model->title?>

                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="card-body">

                                <?=$this->render('_form', [
                                    'model' => $model,
                                    'categories' => $categories,
                                ]) ?>


                            </div>
                            <!-- /.card-body-->
                        </div>


                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fab fa-yoast fa-lg "></i>
                                    <?=Yii::t('backend', 'Seo for {modelClass}: ',
                                              ['modelClass'=>'Article']) . ' ' .
                                    $model->title?>

                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="card-body">

                                <?=$this->render('_seoform', [
                                    'model' => $model,
                                    'categories' => $categories,
                                    'seomodel'=>$seomodel
                                ]) ?>


                            </div>
                            <!-- /.card-body-->
                        </div>
                        <!-- /.card -->

                    </div>

                    <!-- /.col -->
                </div>-


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>

<?php
if(isset($pleaseRefresh)){
    $this->registerJs(" $(function () {
                            $('#modal2').modal('toggle');
                        });");
}
?><?php

    yii\bootstrap4\Modal::begin([
                                    'id' =>'modal2',
                                    //'headerOptions' => ['id' => 'modalHeader'],
                                    'title' => 'AI Generated meta',

                                ]);

    yii\bootstrap4\Modal::end(); ?>