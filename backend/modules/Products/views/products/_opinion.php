<?php
    //use kartik\rating\StarRating;
    
    /*use backend\assets\BootstrapstarratingAsset;
    BootstrapstarratingAsset::register($this);*/
    use yii\helpers\Html;
?>

<div class="col-sm-6 col-margin opinion-container">
    <div class="col-item">
        <div class="row">
            <div class="col-xs-4 opinion-profile-image">
                 <?= Html::img($model->user->profile->thumb,['class'=>'img-responsive w100 img-circle']) ?>
            </div>
            <div class="col-xs-8 prod-rating-col">
                <div class="prod-rating-list-name">
                    <?= $model->user->username ?>
                    <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id==$model->user_id || Yii::$app->getModule('users')->isAdmin())) { ?>
                        <div class="pull-right">
                            <a data-toggle="modal" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['products/productsopinion/update', 'id'=>$model->id]) ?>" data-target="#myModal"><span class="glyphicon glyphicon-edit opinion-buttons"></span></a>
                            <?php echo Html::a('<span class="glyphicon glyphicon-trash opinion-buttons"></span>',['/products/productsopinion/delete'], [
                                'onclick'=>"
                                    if (confirm('".Yii::t('app','Biztos, hogy törlöd?')."')) {
                                        $.ajax({
                                       type     :'POST',
                                       cache    : false,
                                       url  : '/products/productsopinion/delete',
                                       data: {id:".$model->id."},
                                        success  : function(result) {
                                            $('#opinions-slider').html(result.content);
                                            $('#productp-ratings').html(result.count);
                                            $('#product-ratings-count-top').html(result.count);
                                            $('#product-ratings-count').html(result.count);
                                            $('#product-ratings-average').html(result.average);
                                            $('#rating-average').rating('update', result.average);
                                            $('#rating-average-top').rating('update', result.average);
                                        }
                                       });
                                    }
                                    return false;",
                                ]); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="prod-rating-list-text"><?= $model->comment ?></div>
                <div class="rating pull-right rat-pad-right">
                    <!--<i class="price-text-color fa fa-star"></i>
                    <i class="price-text-color fa fa-star"></i>
                    <i class="price-text-color fa fa-star"></i>
                    <i class="price-text-color fa fa-star"></i>
                    <i class="fa fa-star"></i>-->
                    
                    
                    
                    <script>
                        jQuery(document).ready(function () {
                            $("#rating-<?= $model->id ?>").rating({
                                min:0,
                                max:5,
                                step:0.1,
                                size:'lg',
                                readonly: true,
                                showClear: false,
                                showCaption: false,
                                filledStar: '<i class="price-text-color fa fa-star"></i>',
                                emptyStar: '<i class="fa fa-star"></i>',
                            });
                        });
                    </script>
                    
                    <input id="rating-<?= $model->id ?>" type="number" value="<?= $model->rating ?>" class="rating" data-rtl="false">
                
                <?php /*echo StarRating::widget([
                        'name' => 'rating'.$model->id,
                        'value' => $model->rating,
                        'pluginOptions' => [
                            'readonly' => true,
                            'showClear' => false,
                            'showCaption' => false,
                            'filledStar' => '<i class="price-text-color fa fa-star"></i>',
                            'emptyStar' => '<i class="fa fa-star"></i>',
                        ]
                ]);*/ ?>
                </div>
            </div>
            <div class="col-xs-12"></div>
        </div>
    </div>
</div>