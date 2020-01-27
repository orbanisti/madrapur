<?php

    use backend\modules\Reservations\models\Reservations;
    use backend\modules\Reservations\models\ReservationsImport;
    use kartik\widgets\ActiveForm;
    use yii\bootstrap4\Html;
    use \kartik\widgets\DatePicker;

?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    All Importer
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <?php



                ?>
                <div class="box">


                    <?php

                        $form = ActiveForm::begin(
                            [
                                'id' => 'date-import',
                                'options' => ['class' => 'modImp'],
                            ]
                        ) ?>

                    <style>
                        .dateImportWidget {
                            background-color: #eee;
                            padding: 10px;
                        }

                        .dateImportWidget input {
                            width: 20%;

                        }


                    </style>
                    <div class="box-title"><h2>Importálás</h2></div>


                    <div class="dateImportWidget">
                        <?php
                            $model=new Reservations();

                        ?>

                        <?= $form->field($model, 'invoiceDate')->widget(
                            DatePicker::class, [
                                                 'type' => DatePicker::TYPE_COMPONENT_PREPEND
                                                 , 'options' => [
                                                     'value' => date('Y-m-d', time()),
                                                     'class' => 'bg-gradient-info '

                                                 ],
                                                 'pluginOptions' => [

                                                     'autoclose' => true,

                                                     'format' => 'yyyy-mm-dd',


                                                 ],


                                             ]
                        ) ?>
                        <?= $form->field($model, 'source')->dropDownList(array('https://budapestrivercruise.eu'
                                                                                    => 'https://budapestrivercruise.eu', 'https://silver-line.hu' => 'https://silver-line.hu'), array('options' => array('https://budapestrivercruise.eu' => array('selected' => true)))); ?>

                        <?php
                            echo Html::submitButton(
                                Yii::t('backend', 'Importálás'),
                                [
                                    'class' => 'btn btn-info btn-lg btn-flat btn-block',
                                    'name' => 'import-button'
                                ]
                            )

                        ?>


                        <?php ActiveForm::end();



                        ?>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>