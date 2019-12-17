<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\Modevent\models\Modevent $model
 */


?>
<div class="modevent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
