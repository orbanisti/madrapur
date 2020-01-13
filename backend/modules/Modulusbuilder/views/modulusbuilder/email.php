<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 *
 * @var $this yii\web\View
 * @var $searchModel \backend\models\search\PageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model common\models\Page
 */

?>

<div class="container">
    <div class="row">
        <div class="col-lg-3">


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>  <?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'New Template']) ?>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">



                    <div class="box box-success collapsed-box">

                        <div class="box-body">
                            <?php

                                echo $this->render('_form', [
                                    'model' => $model,
                                ]) ?>
                        </div>
                    </div>


                </div>
                <!-- /.card-body-->
            </div>
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
                                    ],

                                    [
                                        'attribute' => 'name',
                                        'value' => function ($model) {
                                            return Html::a($model->name, [
                                                'update',
                                                'id' => $model->id
                                            ]);
                                        },
                                        'format' => 'raw',
                                    ],
                                    'body',

                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{delete}',
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








