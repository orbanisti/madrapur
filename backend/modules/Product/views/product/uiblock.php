<?php

    use kartik\icons\Icon;
    use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

    <div class="row">
        <div class="col-lg-12">


            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>  <?php echo Yii::t('backend', 'Timetable') ?>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">

                    <div class="product-default-index">

                        <?php
                            /**
                             * Json RPC Communication TODO Close this hole asap
                             */
                            /*
                             * Example of Yell function of Api Rester returns free spaces of productId on selecetedDate in Int
                                $client = new \nizsheanez\jsonRpc\Client('http://www.api.localhost.com/v1/worker');
                                $currentProduct=44;

                                $selectedDate=date("Y-m-d");

                                $response = $client->yell($selectedDate,$currentProduct);
                                echo $response;
                            */

                        ?>

                        <script type='text/javascript'>
                            <?php

                            $js_array = json_encode($images);
                            echo "var productimages = " . $js_array . ";\n";
                            ?>
                        </script>
                        <style>
                            button {
                                margin: 5px;
                            }

                        </style>

                        <div class="col-sm-8 ui-inputs">

                            <?php

                                $format = <<< SCRIPT

function format(state) {
    if (!state.id) return state.text; // optgroup
    src =productimages[state.id.toLowerCase()]
    return '<img class="flag" style="width:20px;height:20px;" src="' + src + '"/>' + state.text;
}

SCRIPT;

                                $escape = new JsExpression("function(m) { return m; }");
                                $this->registerJs($format, View::POS_HEAD);

                                $form = ActiveForm::begin([
                                    'id' => 'product-edit',
                                    'action' => 'uiblock',
                                    'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],

                                ]);
                                echo $form->field($model, 'id')->widget(Select2::classname(), [
                                    'name' => 'state_12',
                                    'data' => $data,
                                    'options' => ['placeholder' => 'Select a product ...'],
                                    'pluginOptions' => [
                                        'templateResult' => new JsExpression('format'),
                                        'templateSelection' => new JsExpression('format'),
                                        'escapeMarkup' => $escape,
                                        'allowClear' => true
                                    ],
                                ])->label('Product');

                            ?>
                            <?php
                                echo Html::submitButton(Yii::t('backend', 'Block Days&nbsp;'.Icon::show('sun')),
                                    [
                                        'class' => 'btn btn-primary btn-flat',
                                        'name' => 'blocking-button',
                                        'value' => 'dayBlocking'
                                    ]);
                                echo Html::submitButton(Yii::t('backend', 'Block Times&nbsp;'.Icon::show('clock')),
                                    [
                                        'class' => 'btn btn-info btn-flat',
                                        'name' => 'blocking-button',
                                        'value' => 'timeBlocking'
                                    ]);
                                echo Html::submitButton(Yii::t('backend', 'Time Table&nbsp;'.Icon::show('calendar')),
                                    [
                                        'class' => 'btn btn-warning btn-flat',
                                        'name' => 'blocking-button',
                                        'value' => 'timeTable'
                                    ]);

                            ?>


                            <?php ActiveForm::end(); ?>


                            <?php


                                // $prodInfo=Product::getProdById(43); //With this method you get every information about a product with $id

                            ?>
                            </p>
                        </div>
                    </div>


                    </div>


                </div>
                <!-- /.card-body-->
            </div>
        </div>


    </div>
</div>
