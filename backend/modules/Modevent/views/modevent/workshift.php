<?php

    use backend\modules\Modevent\models\Workshift;
    use kartik\datecontrol\DateControl;
    use kartik\detail\DetailView;
    use kartik\form\ActiveForm;
    use kartik\icons\Icon;
    use kartik\select2\Select2;
    use kartik\time\TimePicker;
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
    <div class="col-lg-4 col-sm-12">
        <!-- interactive chart -->
        <div class="card card-info ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-key fa-fw "></i>
                    Create Workshift

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?php
                  /*  $model=new Workshift();
                    $model->place='Docker';
                    echo DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
           'place'
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ;
*/                $model=new Workshift();
?>

                <?php

                $form = ActiveForm::begin([
                                                   'id' => 'product-update',
//                                                   'action' => 'create',
                                                   'options' => ['class' => 'prodUpdate'],
                                               ]);

                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php

                            echo $form->field($model, 'place')->textInput()->label('Place');

                            echo $form->field($model, 'startTime')->widget(
                                TimePicker::classname(), [

                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                    'minuteStep' => 1,

                                ]
                            ]);
                            echo $form->field($model, 'endTime')->widget(
                                TimePicker::classname(), [

                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                    'minuteStep' => 1,

                                ]
                            ]);
                            echo $form->field($model,'role')->dropDownList(['Seller'=>'Seller','Street Seller'=>'Street Seller',
                                                                            'Coordinator'=>'Coordinator'])

                        ?>

                        <?php


                            echo Html::submitButton(Yii::t('backend', 'Create Workshift'.Icon::show('key')),
                                                    [
                                                        'class' => 'btn btn-info btn-flat',
                                                        'name' => 'blocking-button',
                                                        'value' => 'workshiftcreate'
                                                    ]);

                            ActiveForm::end();


                        ?>
                    </div>
                </div>















            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>
    <div class="col-lg-8 col-sm-12">
        <!-- interactive chart -->
        <div class="row">
            <div class="col-12">
                <!-- interactive chart -->
                <div class="card card-info ">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard fa-fw "></i>
                            Workshifts
                        </h3>
        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
        
                        </div>
                    </div>
                    <div class="card-body">
                        <?php Pjax::begin(); echo GridView::widget([
                                                                       'dataProvider' => $dataProvider,
                                                                       'columns' => [


                                                                          'place',
                                                                          'startTime',
                                                                          'endTime',
                                                                          'role',

                                                                           [
                                                                               'class' => 'kartik\grid\ActionColumn',
                                                                               'template' => '{update}{delete}',
                                                                               'buttons' => [
                                                                                   'delete' => function ($url, $model) {
                                                                                       return Html::a('<i class="fas fa-trash-alt  "></i>',
                                                                                                      Yii::$app->urlManager->createUrl(['Modevent/modevent/workshift', 'id' => $model->id, 'delete' => '1']),
                                                                                                      ['title' =>
                                                                                                           Yii::t('yii', 'Delete'),]
                                                                                       );
                                                                                   },

                                                                                   'view'=> function($url,$model){
                                                                                        return null;
                                                                                   }
                                                                               ],
                                                                           ],
                                                                       ],
                                                                       'responsive' => true,
                                                                       'hover' => true,
                                                                       'condensed' => true,
                                                                       'layout' => '{items}',



                                                                   ]); Pjax::end(); ?>
                       
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- /.card -->
        
            </div>   
         
            <!-- /.col -->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>



