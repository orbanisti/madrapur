<?php

use yii\helpers\Html;
use backend\modules\Products\models\Products;
use backend\components\extra;
use backend\models\Shopcurrency;
use yii\helpers\Url;

use backend\assets\BootstrapstarratingAsset;
    BootstrapstarratingAsset::register($this);

?>

<div class="col-sm-3 col-margin product-list-view">
    <div class="col-item">
    <?= Html::a('<div class="prod-thumb-hover"></div>'.Html::img($model->thumb,['class'=>'img-responsive w100', 'alt'=>$model->name]),Products::getUrlbyid($model->id), ['class'=>'prod-thumb-link']); ?>
        <div class="info">
            <?= Html::a('<h3 class="homep-prod-name">'.$model->name.'</h3>',Products::getUrlbyid($model->id)); ?>
            <p class="homep-prod-text"><?= extra::getIntro($model->intro,80);?></p>
            <div class="homep-prod-place"><img class="homep-prod-place-img" src="/img/place.png" alt="Mandelan" /><span><?= $model->city ?></span> <?= $model->country ?></div>
            <div class="row">
                <div class="price col-md-6">
                    <a class="grid-addtocart" data-toggle="modal" href="<?= Url::to(['/order/shoppingcart/popup','id'=>$model->id]) ?>" data-target="#addtocart-modal"></a>
                    <h5 class="homep-prod-price-nomp"><?= Shopcurrency::priceFormat($model->minimalpricenomp) ?></h5>
                    <h5 class="homep-prod-price"><?= Shopcurrency::priceFormat($model->minimalprice) ?></h5>
                </div>
                <div class="rating hidden-sm col-md-6">
                    <script>
                        jQuery(document).ready(function () {
                            $("#rating-averagem-<?= $model->id ?>").rating({
                                min:0,
                                max:5,
                                step:0.1,
                                size:'sm',
                                readonly: true,
                                showClear: false,
                                showCaption: false,
                                filledStar: '<i class="price-text-color fa fa-star"></i>',
                                emptyStar: '<i class="fa fa-star"></i>',
                            });
                        });
                    </script>

                    <input class="hide" id="rating-averagem-<?= $model->id ?>" type="number" value="<?= round($model->opinionsaverage,1) ?>" class="rating" data-rtl="false">

                </div>
                <div class="col-md-6 col-md-offset-6">
                    <div class="homep-ratings"> <?= count($model->opinions) ?> <?= Yii::t('app','vélemény'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

