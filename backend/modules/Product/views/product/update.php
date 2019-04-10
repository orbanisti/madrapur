<?php



use yii\helpers\Html;



/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Products */



$this->title = Yii::t('app', 'Termék szerkesztése') . ' <u>'.$model->title.'</u>';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Termékek'), 'url' => ['admin']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztés');

?>

<div class="products-update">



    <h1><?= $this->title ?></h1>

    <?php

    switch ($updateResponse){
        case 1:
            $updateResponse = '<span style="color:green">Product Update Successful</span>';
            break;
        case 0:
            $updateResponse = '<span style="color:red">Product Update Failed</span>';

    }
    echo $updateResponse;
    ?>


    <?=

        $this->render('editForm', [
        'model' => $model,
        'backenddata'=>$backendData,
        'prodId'=>$prodId,
        'modelTimes'=>$modelTimes,



/*
        'modelTranslations' => $modelTranslations,

        'modelPrices' => $modelPrices,
        'modelTimes' => $modelTimes

*/
    ]) ?>



</div>

