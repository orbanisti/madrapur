
<?php

    use kartik\form\ActiveForm;
    use kartik\icons\Icon;
    use kartik\widgets\TimePicker;
    use yii\helpers\Html;



?>


        <div class="row">
            <div class="col-12">
                <!-- interactive chart -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Workshift

                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $form = ActiveForm::begin([
                                                          'id' => 'product-update',
                                                          //                                                   'action' => 'create',
                                                          'options' => ['class' => 'prodUpdate'],
                                                      ]);

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


                            echo Html::submitButton(Yii::t('backend', 'Update Workshift '),
                                                    [
                                                        'class' => 'btn btn-info btn-flat',
                                                        'name' => 'blocking-button',
                                                        'value' => 'workshiftcreate'
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
