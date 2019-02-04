<?php


use yii\helpers\Html;
use backend\modules\Products\models\Services;
use backend\assets\BootstrapstarratingAsset;
use yii\helpers\Url;
use backend\modules\Products\models\Products;
use yii\helpers\ArrayHelper;
use Requests as Req;
use yii\helpers\Json;
use backend\components\extra;

BootstrapstarratingAsset::register($this);

if($model->source==Products::SOURCE_GADVENTURERS) {
    try {
        $response = Req::get('https://rest.gadventures.com/tour_dossiers/'.$model->gadventurers_id,['X-Application-Key' => 'test_278ed12926866041dbb01abc46af00a5cb75f917']);
        $dossiers=Json::decode($response->body); // részletes leírás
        //extra::e($dossiers);
    } catch (Exception $e) {
        //echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
Yii::$app->language = Yii::$app->request->cookies->getValue(Yii::$app->params['langCookiename']);

$this->title = Yii::t('app',$model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; //Yii::$app->extra->e($model);
?>

<?= Yii::$app->controller->renderPartial("@app/themes/mandelan/site/_filters"); ?>
<div class="col-100">
<div class="container-fluid main-content">

    <div class="row">

        <div class="col-md-9">
            <ol class="breadcrumb">
                <li><a href="/"><?= Yii::t('app','Kezdőlap') ?></a></li>
                <li><a href="<?= $model->countryurl ?>"><?= $model->country ?></a></li>
                <li><a href="<?= $model->cityurl ?>"><?= $model->city ?></a></li>
                <li><a href="<?= $model->categoryurl ?>"><?= $model->category->name ?></a></li>
            </ol>
        </div>

        <div class="col-md-3">
            <!-- Controls -->
            <div class="controls pull-right hidden-xs prod-back-btn">
                <a class="left btn btn-left" href="javascript:history.go(-1)"><?= Yii::t('app','VISSZA') ?></a>
            </div>
        </div>

    </div>
    <div class="carousel-row">
        <div class="row productp-row">
            <div class="col-sm-6 productp-col">
                <?php
                $items[] = [
                        'url' =>$model->picture,
                        'src' =>$model->medium,
                        //'options' => array('title' => $model->name,'class' => 'w100 img-responsive hvr-float-shadow')
                        'options' => array('title' => $model->name,'class' => 'img-responsive hvr-float-shadow')
                    ];
                foreach ($model->getBehavior('galleryBehavior')->getImages() as $image) {
                    $items[] = [
                        'url' => $image->getUrl("original"),
                        'src' => Yii::$app->imagecache->createUrl('product-smallthumb', $image->getUrl("original")),
                        'options' => array('title' => $image->name, 'style'=>'display: none;', )
                    ];
                }
                ?>
                <?= dosamigos\gallery\Gallery::widget(['items' => $items]); ?>
                <?php //Html::a(Html::img($model->medium, ['class' => 'w100 img-responsive']), Products::getUrlbyid($model->id), ['class' => 'photo']); ?>
            </div>

            <div class="col-sm-6 productp-col2 prod-right">
            
            <h1 class="product-name"> <?=Yii::t('app',Html::encode($this->title)) ?></h1>
                <div class="product-place"><img class="homep-prod-place-img" src="<?php echo $this->theme->baseUrl; ?>/img/place.png"/><span><a href="<?= $model->cityurl ?>"><?= $model->city ?></span>
                    <a href="<?= $model->countryurl ?>"><?= $model->country ?></a>
                </div>

                <div class="product-text"><?= Yii::t('app',(!empty($dossiers))?$dossiers['description']:$model->intro); ?> </div>

                <?php
                if($model->duration !=0 ) {
                ?>
                <div class="product-text"><?= Yii::t('app','Időtartam').': '.$model->duration.' '.Products::durationtype($model->duration_type) ?> </div>
                <?php } ?>

            </div>

            <a class="btn send-msg-from-prod" href="<?= Url::to(['/messages/messages/create', 'user' => $model->user_id]) ?>"><?= Yii::t('app','ÜZENETET KÜLDÖK') ?></a>

            <div class="productp-rat-col">
                <div class="productp-ratings-fa">
                    <script>
                        jQuery(document).ready(function () {
                            $("#rating-average-top").rating({
                                min: 0,
                                max: 5,
                                step: 0.1,
                                size: 'sm',
                                readonly: true,
                                showClear: false,
                                showCaption: false,
                                filledStar: '<i class="price-text-color fa fa-star"></i>',
                                emptyStar: '<i class="fa fa-star"></i>',
                            });
                        });
                    </script>

                    <input class="hide" id="rating-average-top" type="number" value="<?= round($model->opinionsaverage, 1) ?>" class="rating" data-rtl="false">

                </div>
                <div><span id="product-ratings-count-top"><?= $model->opinionscount ?></span> <?= Yii::t('app','vélemény') ?></div>
            </div>

            <div class="product-actions">
                <a class="show-news-share-icons" href="#"><img src="<?php echo $this->theme->baseUrl; ?>/img/like.jpg"/></a>
                <a href="mailto:?subject=mandelan&body=<?= Yii::t('app','Hello, Most találtam ezt a hirdetés, talán érdekelhet: ') ?><?= $model->url ?>"><img src="<?php echo $this->theme->baseUrl; ?>/img/mail.jpg"/></a>
                <a href="<?= $model->pdfurl ?>"><img src="<?php echo $this->theme->baseUrl; ?>/img/pdf.jpg"/></a>
                <div onclick="printDiv('printcontent')" style="display: inline-block;" ><img src="<?php echo $this->theme->baseUrl; ?>/img/print.jpg"/></div>
                    <div class="news-share-icons">
                        <a class="news-share-icon" href="https://twitter.com/home?status=<?= $model->url ?>"><img src="/img/share-icon-tw.jpg"></a>
                        <a class="news-share-icon" href="https://www.facebook.com/sharer/sharer.php?u=<?= $model->url ?>"><img src="/img/share-icon-fb.jpg"></a>
                        <a class="news-share-icon" href="https://pinterest.com/pin/create/button/?url=&media=<?= $model->url ?>"><img src="/img/share-icon-pt.jpg"></a>
                        <a class="news-share-icon" href="https://plus.google.com/share?url=<?= $model->url ?>"><img src="/img/share-icon-gp.jpg"></a>
                    </div>
                <div id="printcontent" style="display: none;">
                    <?php
                    echo '<h1>'.$model->name.'</h1><br/>';
                    echo Html::img($model->thumb).'<br/><br/>';
                    echo $model->intro.'<br/>';
                    echo $model->description.'<br/>';
                    echo $model->other_info.'<br/>';
                    $services=Services::getServicesbyids($model->serviceslist);
                    if(count($services)>0) {
                        echo Yii::t('app','Szolgáltatások').'<ul>';
                        foreach ($services as $service){
                            echo '<li>'.$service->name.'</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>

                <script>
                    function printDiv(divName) {
                        var printContents = document.getElementById(divName).innerHTML;
                        var originalContents = document.body.innerHTML;

                        document.body.innerHTML = printContents;

                        window.print();

                        document.body.innerHTML = originalContents;
                   }
                </script>
            </div>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_addtocart_types', ['model' => $model]) ?>

    <div class="tabs-content">

        <?php
            $terms=$model->user->termsconditions; $termsh=false; $tstyle='';
            if(!empty($terms) && $terms->content!='') {
                $termsh=true;
                $tstyle=' style="width: 24%;"';
            }
        ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" <?= $tstyle ?>>
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?= Yii::t('app','RÉSZLETES LEÍRÁS'); ?></a>
            </li>
            <li role="presentation" <?= $tstyle ?>>
                <a href="#info" aria-controls="profile" role="tab" data-toggle="tab"><?= Yii::t('app','FONTOS INFORMÁCIÓK'); ?><img class="pull-right tab-img" src="<?php echo $this->theme->baseUrl; ?>/img/info.png"/> </a>
            </li>
            <?php if($termsh) { ?>
                <li role="presentation" <?= $tstyle ?>>
                    <a href="#terms" aria-controls="profile" role="tab" data-toggle="tab"><?= Yii::t('app','Felhasználási feltételek'); ?></a>
                </li>
            <?php } ?>
            <li role="presentation" <?= $tstyle ?>>
                <a href="#pictures" aria-controls="messages" role="tab" data-toggle="tab"><?= Yii::t('app','KÉPEK'); ?><img class="pull-right tab-img" src="<?php echo $this->theme->baseUrl; ?>/img/pictures.png"/></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content product-info-tabcontents">
            <div role="tabpanel" class="tab-pane active" id="home">
                <p><?= ($model->source!=Products::SOURCE_GADVENTURERS)?$model->description:'' ?></p>
                <?php
                $services=ArrayHelper::map(Services::getServicesbyids($model->serviceslist),'id','name');
                if(count($services)>0) {
                    asort($services, SORT_STRING);
                    echo Yii::t('app','Szolgáltatások').'<ul>';
                    foreach ($services as $service){
                        echo '<li>'.$service.'</li>';
                    }
                    echo '</ul>';
                }
                if(!empty($dossiers)) {
                    if(!empty($dossiers['itineraries'][1]['days'])) {
                        foreach ($dossiers['itineraries'][1]['days'] as $day) {
                            echo '<h4>'.$day['label'].'</h4>';
                            echo '<p>'.$day['body'].'</p>';
                        }
                    }
                }
                ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="info">
                <p><?= $model->other_info ?></p>
                <?php
                if(!empty($dossiers)) {
                    if(!empty($dossiers['details'])) {
                        foreach ($dossiers['details'] as $detail) {
                            echo '<h4>'.$detail['detail_type']['label'].'</h4>';
                            echo '<p>'.$detail['body'].'</p>';
                        }
                    }
                }
                ?>
            </div>

            <?php if($termsh) { ?>
                <div role="tabpanel" class="tab-pane" id="terms">
                    <p><?= $terms->content ?></p>
                </div>
            <?php } ?>

            <div role="tabpanel" class="tab-pane" id="pictures">
                <?php
                $items = [];
                foreach ($model->getBehavior('galleryBehavior')->getImages() as $image) {
                    $items[] = [
                        'url' => $image->getUrl("original"),
                        'src' => Yii::$app->imagecache->createUrl('product-smallthumb', $image->getUrl("original")),
                        'options' => array('title' => $image->name)
                    ];
                }
                ?>

                <?= dosamigos\gallery\Gallery::widget([
                    'items' => $items,
                        'options' => [
                            'id' => 'gallery-widget-' . $model->id,
                        ],
                        'templateOptions' => [
                            'id' => 'blueimp-gallery-' . $model->id
                        ],
                        'clientOptions' => [
                            'container' => '#blueimp-gallery-' . $model->id
                        ]
                    ]); ?>
            </div>
        </div>
    </div>

    <div class="row prod-rating-container">

        <div class="col-sm-9 productp-ratings-col">
            <div class="productp-ratings-row">
                <?= Yii::t('app','hozzászólás / értékelés'); ?> <img class="pull-right ratting-img" src="<?php echo $this->theme->baseUrl; ?>/img/rattings.png"/>
            </div>

            <div id="carousel-example" class="carousel slide carousel-left-margin" data-ride="carousel">

                <!-- Wrapper for slides -->
                <div class="carousel-inner" id="opinions-slider">
                    <?= $this->render('@webroot/modules/Products/views/products/_opinions', ['model' => $model]); ?>
                </div>

            </div>

            <div class="col-md-12">

                <!-- Controls -->
                <div class="controls pull-right hidden-xs">
                    <a class="left btn btn-left" href="#carousel-example" data-slide="prev"></a>
                    <a class="right btn btn-right" href="#carousel-example" data-slide="next"></a>
                </div>

            </div>

        </div>

        <div class="col-sm-3">

            <div class="productp-new-ratings-row">
                <a data-toggle="modal" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['products/productsopinion/create', 'id' => $model->id]) ?>" data-target="#myModal"><img src="<?php echo $this->theme->baseUrl; ?>/img/new-ratting.png"> <?= Yii::t('app','ÚJ HOZZÁSZÓLÁS') ?></a>
            </div>

            <div class="text-center ratting-num"><span id="product-ratings-count"><?= $model->opinionscount ?></span> vélemény</div>

            <div class="text-center ratting-mark" id="product-ratings-average"><?= round($model->opinionsaverage, 1) ?></div>

            <div class="rating2 text-center">
                <script>
                    jQuery(document).ready(function () {
                        $("#rating-average").rating({
                            min: 0,
                            max: 5,
                            step: 0.1,
                            size: 'sm',
                            readonly: true,
                            showClear: false,
                            showCaption: false,
                            filledStar: '<i class="price-text-color fa fa-star"></i>',
                            emptyStar: '<i class="fa fa-star"></i>',
                        });
                    });
                </script>

                <input class="hide" id="rating-average" type="number" value="<?= round($model->opinionsaverage, 1) ?>" class="rating" data-rtl="false">

            </div>
        </div>
    </div>
</div></div></div>

