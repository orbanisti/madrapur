<?phpbackend\
use yii\helpers\Html;
use app\models\Shopcurrency;
?>

<div class="col-sm-4">
    <div class="ac-price-title"><?= Yii::t('app','Bruttó ár') ?> :</div>
    <div class="ac-price-num" id="total-price"><?= '<span>'.  Shopcurrency::priceFormat($product->minimalprice).'</span> '.Yii::t('app','/fő') ?></div>
</div>

<div class="col-sm-4">
    <?php //($product->book_url!='')?Html::a(Yii::t('app','Weboldal megtekintése'), $product->tour_url_tracked, ['target'=>'_blank', 'class'=>'gl-tour-link hvr-bounce-in']):'' ?>
    <?php //Html::a(Yii::t('app','Weboldal megtekintése'), $product->tour_url_tracked, ['target'=>'_blank', 'class'=>'gl-tour-link hvr-bounce-in']) ?>
</div>

<div class="col-sm-4">
    <?php //($product->book_url!='')?Html::a(Yii::t('app','Megrendelés'), $product->book_url, ['target'=>'_blank', 'class'=>'gl-book-link hvr-bounce-in']):Html::a(Yii::t('app','Weboldal megtekintése'), $product->tour_url_tracked, ['target'=>'_blank', 'class'=>'gl-book-link hvr-bounce-in']) ?>
    <?php
        if($product->book_url!='' && $product->enquire_only==0) {
            echo Html::a(Yii::t('app','Megrendelés'), $product->book_url, ['target'=>'_blank', 'class'=>'gl-book-link hvr-bounce-in']);
        } else {
            //echo Html::a(Yii::t('app','Árajánlat kérése'), $product->tour_url_tracked, ['target'=>'_blank', 'class'=>'gl-book-link hvr-bounce-in']);
        ?>
        <a data-toggle="modal" class="gl-book-link hvr-bounce-in" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['products/products/enquire', 'id' => $product->id]) ?>" data-target="#myModal"><?= Yii::t('app','Árajánlat kérése') ?></a>
    <?php
        }
    ?>
</div>
