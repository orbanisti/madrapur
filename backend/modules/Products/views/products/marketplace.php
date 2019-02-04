<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::t('app', 'Piactér');
?>

<?= Yii::$app->controller->renderPartial("@app/themes/mandelan/site/_filters"); ?>

<div class="col-80 products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_gridview',
        'layout' => '{items}<div class="clear"></div>{pager}',
    ]); ?>

</div>

