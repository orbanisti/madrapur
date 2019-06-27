<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>



<div class="modmail-default-index">
   <div class="panel">

       <div class="panel-heading">
           <h3>Mail test</h3>
       </div>
       <div class="panel-body">
           <?php


           $form = ActiveForm::begin([
               'id' => 'login-form',
               'options' => ['class' => 'form-horizontal'],
           ]) ?>
           <?= $form->field($model, 'from')->textInput(['value'=>'info@budapestrivercruise.co.uk']); ?>
           <?= $form->field($model, 'to')->textInput(); ?>
           <?= $form->field($model, 'subject')->textInput(); ?>
           <?= $form->field($model, 'body')->textarea(); ?>


           <div class="form-group">
               <div class="col-lg-4 col-lg-12">
                   <?= Html::submitButton('Send Mail', ['class' => 'btn btn-primary']) ?>
               </div>
           </div>
           <?php ActiveForm::end() ?>




       </div>



   </div>
   <div class="panel">
       <div class="panel-heading">
           <h3>Mail log</h3>
       </div>
       <div class="panel-body">
           <?= \yii\grid\GridView::widget([
           'pager' => [
           'firstPageLabel' => Yii::t('app', 'Első oldal'),
           'lastPageLabel' => Yii::t('app', 'Utolsó oldal'),
           ],
           'dataProvider' => $dataProvider,
           'filterModel' => $searchModel,
           'columns' => $gridColumns,
           ]);?>
       </div>

   </div>

</div>
