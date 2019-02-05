div class="col-80"

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = $model->title;
?>

<div class="country-cover" style="background-image: url(<?= $model->cover ?>);">
    <div class="cover-container">
        <h1><?= $model->title ?></h1>
    </div>
    <div class="cover-time-weather">
        <?= Yii::$app->controller->renderPartial("/default/_time_weather", ['name'=>$model->title, 'code'=>$model->country->country_code]) ?>
    </div>
</div>

<?= Yii::$app->controller->renderPartial("@app/themes/mandelan/site/_filters"); ?>

<div class="col-80">
    <div class="col-sm-12">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'firstPageLabel' => Yii::t('app','Első oldal'),
                'lastPageLabel'  => Yii::t('app','Utolsó oldal'),
            ],
            'itemView' => '@app/modules/Products/views/products/_gridview',
            'layout' => '{items}<div class="clear"></div>{pager}',
        ]); ?>

        <?php if(!empty($model->sights)) { ?>
        <h2 class="country-headings"><i class="fa fa-binoculars" aria-hidden="true"></i><?= Yii::t('app','Top {count} látványosság',['count'=>count($model->sights)]).' '.$model->title ?></h2><br/>
        <?= ($model->sights_info!='')?('<div class="clear city-sights-info">'.$model->sights_info.'</div>'):'' ?>
        <div class="clear city-sights">
            <?php $i=1;
            foreach($model->sights as $sights) { ?>
                <div class="<?= ($i<=4)?'col-md-6':'col-md-4' ?> city-sight">
                    <?= Html::img($sights->thumb.'?1'); ?>
                    <h3><?= $i.'. '.$sights->name ?></h3>
                    <p><?= $sights->description ?></p>
                </div>
            <?php $i++; } ?>
        </div>
        <?php } ?>

        <?php if($model->language!='' || $model->currency!='' || $model->phone_code!='' || $model->transport!='' || $model->plug!='' || $model->when!='') {
            echo '<h2 class="country-headings"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'.Yii::t('app','Fontos információk').'</h2>';
            echo '<div class="clear country-goodtoknow">';
            echo ($model->language!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-globe"></i>'.Yii::t('app','Nyelv').'</span>'.$model->language.'</div>':'';
            echo ($model->currency!='')?'<div class="col-md-4"><span><i class="fa fa-usd" aria-hidden="true"></i>'.Yii::t('app','Pénznem').'</span>'.$model->currency.'</div>':'';
            echo ($model->phone_code!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-earphone"></i>'.Yii::t('app','Országkód').'</span>'.$model->phone_code.'</div>':'';
            echo ($model->transport!='')?'<div class="col-md-4"><span><i class="fa fa-plane" aria-hidden="true"></i>'.Yii::t('app','Közlekedés').'</span>'.$model->transport.'</div>':'';
            echo ($model->plug!='')?'<div class="col-md-4"><span><i class="fa fa-plug" aria-hidden="true"></i>'.Yii::t('app','Csatlakozó').'</span>'.$model->plug.'</div>':'';
            echo ($model->when!='')?'<div class="col-md-4"><span><i class="glyphicon glyphicon-calendar"></i>'.Yii::t('app','Mikor').'</span>'.$model->when.'</div>':'';
            echo '</div>';
        } ?>

        <?php if($model->content!='') {
            echo '<h2 class="country-headings"><i class="fa fa-info-circle" aria-hidden="true"></i>'.Yii::t('app','Like a local').'</h2>';
            echo '<div class="clear country-description">';
            echo $model->content;
            echo '</div>';
        } ?>

        <?php if($model->extra_info!='') {
            echo '<h2 class="country-headings"><i class="fa fa-smile-o" aria-hidden="true"></i>'.Yii::t('app','HOT Stuff').'</h2>';
            echo '<div class="clear country-description">';
            echo $model->extra_info;
            echo '</div>';
        } ?>

    </div>
</div>
