<?php



use yii\helpers\Html;



/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Productsopinion */



$this->title = Yii::t('app', 'Új vélemény');

?>

<div class="productsopinion-create">



    <?= $this->render('_form', [

        'model' => $model,

    ]) ?>



</div>

