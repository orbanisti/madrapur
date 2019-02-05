<?php

use yii\helpers\Html;
use backend\components\extra;

use backend\assets\BootstrapstarratingAsset;
    BootstrapstarratingAsset::register($this);

?>

<div class="col-sm-3 col-margin product-list-view">
    <div class="col-item">
    <?= Html::a('<div class="prod-thumb-hover"></div>'.Html::img($model->thumb,['class'=>'img-responsive w100']),$model->url, ['class'=>'prod-thumb-link']); ?>
        <div class="info">
            <?= Html::a('<h5 class="homep-prod-name">'.$model->title.'</h5>',$model->url); ?>
            <p class="homep-prod-text"><?= extra::getIntro($model->content,80);?></p>
            <?php if(!empty($model->city)) { ?>
                <div class="homep-prod-place"><img class="homep-prod-place-img" src="/img/place.png"/><span><?= $model->city->title ?></span> <?= $model->city->country->country_name ?></div>
            <?php } else { ?>
                <div class="homep-prod-place"><img class="homep-prod-place-img" src="/img/place.png"/><span><?= $model->title?></span> <?= $model->country->country_name ?></div>
            <?php } ?>
        </div>
    </div>
</div>

