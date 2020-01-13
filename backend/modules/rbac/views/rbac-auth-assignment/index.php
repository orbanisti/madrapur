<?php

    use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-pen"></i>
                    <?= Yii::t('app', 'Rbac Auth Assignments')?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="rbac-auth-assignment-index">


                    <p>
                        <?php

                            echo Html::a(Yii::t('app', 'Create {modelClass}', [
                                'modelClass' => 'Rbac Auth Assignment',
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
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn'
                                    ],

                                    'item_name',
                                    'user_id',
                                    'created_at:datetime',

                                    [
                                        'class' => \kartik\grid\ActionColumn::class
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
