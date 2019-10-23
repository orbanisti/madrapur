<?php

    use kartik\date\DatePicker;
    use kartik\daterange\DateRangePicker;
    use kartik\form\ActiveForm;
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
                    Subscribe for work

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?php

                ?>
                <div class="form-group">
                    <?php
                        $form= ActiveForm::begin();
                        echo '<label class="control-label">Please select a date range</label>';
                        echo DatePicker::widget([
                                                    'model' => $model,
                                                    'attribute' => 'startDate',
                                                    'attribute2' => 'endDate',
                                                    'options' => ['placeholder' => 'Start date'],
                                                    'options2' => ['placeholder' => 'End date'],
                                                    'type' => DatePicker::TYPE_RANGE,
                                                    'form' => $form,
                                                    'pluginOptions' => [
                                                        'format' => 'yyyy-mm-dd',
                                                        'autoclose' => true,
                                                    ]
                                                ]);

                        echo $form->field($model, 'user')->hiddeninput(['value' => Yii::$app->user->getIdentity()
                            ->username])
                            ->label
                        (false);
                        echo $form->field($model, 'title')->hiddeninput(['value' => 'subscribe'])
                            ->label
                        (false);

                        echo Html::submitButton(Yii::t('backend', 'Subscribe for work'),
                                                [
                                                    'class' => 'btn btn-primary btn-flat',
                                                    'name' => 'blocking-button',
                                                    'value' => 'dayBlocking'
                                                ]);
                        ActiveForm::end();
                    ?>
                </div>

               <div class="row">
                   <div class="col-12">
                       <!-- interactive chart -->
                       <div class="card card-primary card-outline">
                           <div class="card-header">
                               <h3 class="card-title">
                                   My Subscriptions for Work
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
                                           'options' => [
                                               'class' => 'grid-view table-responsive',
                                           ],
                                           'layout' => '{items}',
                                           'columns' => [

                                               [
                                                   'attribute' => 'startDate',
                                               ],
                                               [
                                                   'attribute' => 'endDate',
                                               ],

                                               [
                                                   'class' => 'kartik\grid\ActionColumn',
                                                   'template' => '{delete}',
                                               ],
                                           ],
                                       ]);
                               ?>



                           </div>
                           <!-- /.card-body-->
                       </div>
                       <!-- /.card -->
               
                   </div>   
                
                   <!-- /.col -->
               </div>
            </div>
    
  
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

        
    </div>
    
 
    <!-- /.col -->
</div>