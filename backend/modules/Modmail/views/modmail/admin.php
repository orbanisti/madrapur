<?php


    use yii\helpers\Html;
use yii\widgets\ActiveForm;





?>
<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Mail test
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="panel-heading">

                </div>

                <div class="panel-body">
                    <?php

                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['class' => 'form-horizontal'],
                            'action' => 'send',
                        ]) ?>
                    <?= $form->field($model, 'from')->textInput(['value' => 'info@budapestrivercruise.co.uk', 'required' => true]); ?>
                    <?= $form->field($model, 'to')->textInput(['required' => true]); ?>
                    <?= $form->field($model, 'subject')->textInput(['required' => true]); ?>

                    <?= $form->field($model, 'type')->dropDownList($types); ?>


                    <div class="form-group">
                        <div class="col-lg-4 col-lg-12">
                            <?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>


                </div>
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Mail log
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?= \yii\grid\GridView::widget([
                    'pager' => [
                        'firstPageLabel' => Yii::t('app', 'Első oldal'),
                        'lastPageLabel' => Yii::t('app', 'Utolsó oldal'),
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col -->
</div>


