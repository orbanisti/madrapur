<?php



use yii\helpers\Html;
backend\


/* @var $this yii\web\View */

/* @var $model app\modules\Products\models\Blockouts */



$this->title = Yii::t('app', 'Időpont tíltás módosítása');

?>

<div class="blockouts-update">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

    ]) ?>



</div>

