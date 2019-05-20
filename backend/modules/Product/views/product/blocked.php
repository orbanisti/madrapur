<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;
use kartik\grid\EditableColumn;
use backend\models\Product\Product;



$title ='Block Booking Days of '.'<u>'.$currentProduct->title.'</u>';/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/


?>

<!--suppress ALL -->


<div class="products-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?=$title?></h4>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'product-edit',
                'action' => 'blocked?prodId='.$currentProduct->id,
                'options' => ['class' => 'product-edit','enctype'=>'multipart/form-data'],

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



