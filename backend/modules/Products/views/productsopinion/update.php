<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Products\models\Productsopinion */

$this->title = Yii::t('app', 'Új módosítása');
?>
<div class="productsopinion-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
