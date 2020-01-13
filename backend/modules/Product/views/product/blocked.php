<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
use backend\models\Product\Product;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;

$title = 'Block Booking Days of ' . '<u>' . $currentProduct->title . '</u>';/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/

?>

<!--suppress ALL -->



<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-minus fa-fw"></i>
                    <?= $title ?>
                </h3>

                <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>


                </div>
            </div>
            <div class="card-body">
                <div class="products-index">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <?php
                                $form = ActiveForm::begin([
                                                              'id' => 'product-edit',
                                                              'action' => 'blocked?prodId=' . $currentProduct->id,
                                                              'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],

                                                          ]);

                                echo $form->field($model, 'dates')->widget(\kartik\date\DatePicker::class, [
                                    //'id' => 'products-blockoutsdates',
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'multidate' => true,
                                        'multidateSeparator' => ',',
                                    ]
                                ]);

                                var_dump($returnMessage);
                            ?>

                            <div class="form-group">
                                <br/>
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>

                        </div>

                    </div>
                </div>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>



