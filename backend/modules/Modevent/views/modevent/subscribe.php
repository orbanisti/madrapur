<?php

    use kartik\date\DatePicker;
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
                    $form= ActiveForm::begin();
                    echo '<label class="control-label">Valid Dates</label>';
                    echo DatePicker::widget([
                                                'name' => 'from_date',
                                                'value' => '01-Feb-1996',
                                                'type' => DatePicker::TYPE_RANGE,
                                                'name2' => 'to_date',
                                                'value2' => '27-Feb-1996',
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'yyyy-mm-dd'
                                                ]
                                            ]);

                    ActiveForm::end();
                ?>
               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>