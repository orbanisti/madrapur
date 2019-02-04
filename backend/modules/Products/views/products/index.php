<?php

use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */

/* @var $searchModel app\modules\Products\models\ProductsSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Termékek');

if(!empty($city)) { if(!empty($city->city)) $city=$city->city; ?>
<div class="country-cover" style="background-image: url(<?= $city->cover ?>);">
    <div class="cover-container">
        <h1><?= $city->title ?></h1>
    </div>
    <div class="cover-time-weather">
        <?= Yii::$app->controller->renderPartial("@app/modules/Citydescription/views/default/_time_weather", ['name'=>$city->title, 'code'=>$city->country->country_code]) ?>
    </div>
</div>
<?php } else {
    $this->registerJs('$("#top").css("display", "table");');
}
?>
<?= Yii::$app->controller->renderPartial("@app/themes/mandelan/site/_filters"); ?>



  <div class="container-fluid">
  <div class="row">
            <div class="col-sm-12">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php //\yii\widgets\Pjax::begin(); ?>
    <?= ListView::widget([

        'dataProvider' => $dataProvider,

        'itemView' => '_gridview',

        'layout' => '{items}<div class="clear"></div>{pager}',

    ]); ?>
<?php //\yii\widgets\Pjax::end(); ?>

    <?php if(!empty($city)) { if(!empty($city->city)) $city=$city->city; ?>
        <?php if(!empty($city->sights)) { ?>
        <h2 class="country-headings"><i class="fa fa-binoculars" aria-hidden="true"></i><?= Yii::t('app','Top 10 látványosság').' '.$city->title ?></h2><br/>
        <div class="clear city-sights">
            <?php $i=1;
            foreach($city->sights as $sights) { ?>
                <div class="<?= ($i<=4)?'col-md-6':'col-md-4' ?> city-sight">
                    <?= Html::img($sights->thumb.'?1'); ?>
                    <h3><?= $i.'. '.$sights->name ?></h3>
                    <p><?= $sights->description ?></p>
                </div>
            <?php $i++; } ?>
        </div>
        <?php } ?>

        <?php if($city->language!='' || $city->currency!='' || $city->phone_code!='' || $city->transport!='' || $city->plug!='' || $city->when!='') {
            echo '<h2 class="country-headings"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'.Yii::t('app','Fontos információk').'</h2>';
            echo '<div class="clear country-goodtoknow">';
            echo ($city->language!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-globe"></i>'.Yii::t('app','Nyelv').'</span>'.$city->language.'</div>':'';
            echo ($city->currency!='')?'<div class="col-md-4"><span><i class="fa fa-usd" aria-hidden="true"></i>'.Yii::t('app','Pénznem').'</span>'.$city->currency.'</div>':'';
            echo ($city->phone_code!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-earphone"></i>'.Yii::t('app','Országkód').'</span>'.$city->phone_code.'</div>':'';
            echo ($city->transport!='')?'<div class="col-md-4"><span><i class="fa fa-plane" aria-hidden="true"></i>'.Yii::t('app','Közlekedés').'</span>'.$city->transport.'</div>':'';
            echo ($city->plug!='')?'<div class="col-md-4"><span><i class="fa fa-plug" aria-hidden="true"></i>'.Yii::t('app','Csatlakozó').'</span>'.$city->plug.'</div>':'';
            echo ($city->when!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-calendar"></i>'.Yii::t('app','Mikor').'</span>'.$city->when.'</div>':'';
            echo '</div>';
        } ?>

        <?php if($city->content!='') {
            echo '<h2 class="country-headings"><i class="fa fa-info-circle" aria-hidden="true"></i>'.Yii::t('app','Like a local').'</h2>';
            echo '<div class="clear country-description">';
            echo $city->content;
            echo '</div>';
        } ?>

        <?php if($city->extra_info!='') {
            echo '<h2 class="country-headings"><i class="fa fa-smile-o" aria-hidden="true"></i>'.Yii::t('app','HOT Stuff').'</h2>';
            echo '<div class="clear country-description">';
            echo $city->extra_info;
            echo '</div>';
        } ?>
    <?php } elseif(!empty($country)) { ?>
        <div class="clear country-description">
            <?= $country->content ?>
        </div>

        <div class="clear country-extrainfo">
            <?= $country->extra_info ?>
        </div>
     <?php } ?>
    </div>
    </div>


</div>

