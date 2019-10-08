<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Modevent\models\ModeventSearch $searchModel
 */


?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt fa-fw "></i>
                    Workflow

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="modevent-index">
                    <div class="page-header">
                        <h1><?= Html::encode($this->title) ?></h1>
                    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?php /* echo Html::a('Create Modevent', ['create'], ['class' => 'btn btn-success'])*/  ?>
                    </p>

                    <?php Pjax::begin(); echo GridView::widget([
                                                                   'dataProvider' => $dataProvider,
                                                                   'filterModel' => $searchModel,
                                                                   'columns' => [
                                                                       ['class' => 'yii\grid\SerialColumn'],

                                                                       'id',
                                                                       ['attribute' => 'date','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
                                                                       'place:ntext',
                                                                       'status',
                                                                       'user:ntext',
                                                                       //            'title:ntext', 

                                                                       [
                                                                           'class' => 'yii\grid\ActionColumn',
                                                                           'buttons' => [
                                                                               'update' => function ($url, $model) {
                                                                                   return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                                                                                  Yii::$app->urlManager->createUrl(['Modevent/modevent-crud/view', 'id' => $model->id, 'edit' => 't']),
                                                                                                  ['title' => Yii::t('yii', 'Edit'),]
                                                                                   );
                                                                               }
                                                                           ],
                                                                       ],
                                                                   ],
                                                                   'responsive' => true,
                                                                   'hover' => true,
                                                                   'condensed' => true,
                                                                   'floatHeader' => true,

                                                                   'panel' => [
                                                                       'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
                                                                       'type' => 'info',
                                                                       'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
                                                                       'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                                                                       'showFooter' => false
                                                                   ],
                                                               ]); Pjax::end(); ?>

                </div>

               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>