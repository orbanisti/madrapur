<?php



use yii\helpers\Html;

use yii\widgets\ListView;

/* @var $this yii\web\View */

/* @var $searchModel app\modules\Products\models\ProductsSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Látnivalók');
?>
<h1 class="carousel-row" style="font-size: 18px;"><?= $this->title; ?></h1>

<div class="col-80 products-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php //\yii\widgets\Pjax::begin(); ?>
    <?= ListView::widget([

        'dataProvider' => $dataProvider,

        'itemView' => '_cities_gridview',

        'layout' => '{items}<div class="clear"></div>{pager}',

    ]); ?>
<?php  //\yii\widgets\Pjax::end(); ?>

    <?php if(!empty($city)) { ?>
        <div class="clear country-description">
            <?= $city->content ?>
        </div>

        <div class="clear country-extrainfo">
            <?= (!empty($city->city))?$city->city->country->extra_info:$city->country->extra_info ?>
        </div>
    <?php } elseif(!empty($country)) { ?>
        <div class="clear country-description">
            <?= $country->content ?>
        </div>

        <div class="clear country-extrainfo">
            <?= $country->extra_info ?>
        </div>
     <?php } ?>

</div>

