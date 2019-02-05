<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->country_name;

?>

<div class="country-cover" style="background-image: url(<?= $model->cover ?>);">
    <div class="cover-container">
        <h1><?= $model->country_name ?></h1>
    </div>
    <div class="cover-time-weather">
        <?= Yii::$app->controller->renderPartial("/default/_time_weather", ['name'=>($model->capital!='')?$model->capital:$model->country_name, 'code'=>$model->country_code]) ?>
    </div>
</div>

<?= Yii::$app->controller->renderPartial("@app/themes/mandelan/site/_filters"); ?>

<div class="col-80">

    <div class="row">
        <div class="col-md-9">
            <h2 class="text-uppercase carousel-offer"> <?= Yii::t('app','KIEMELT AJÁNLATAINK'); ?></h2>
        </div>
        <div class="col-md-3">
            <div class="controls pull-right hidden-xs">
                <a class="left btn btn-left" href="#carousel-example" data-slide="prev"></a>
                <a class="right btn btn-right" href="#carousel-example" data-slide="next"></a>
            </div>
        </div>
    </div>
    <div class="carousel-row">
        <div id="carousel-example" class="carousel slide carousel-left-margin" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row mrow">
                        <?php
                        $i=1;
                        foreach ($highlighted as $product) {
                            echo $this->render('@webroot/modules/Products/views/products/_gridview_highlighted', ['model'=> $product]);

                            if(($i%4)==0 && $i!=count($highlighted)) echo '</div></div><div class="item"><div class="row mrow">';
                            $i++;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12">
        <?php
            foreach($bestcities as $bc)
            {
                echo Yii::$app->controller->renderPartial('@app/modules/Citydescription/views/citydescription/_view', ['data'=>$bc->city, 'count'=>(isset($count[$bc->city->id]))?$count[$bc->city->id]:0]);
            }
            foreach($morecities as $bc)
            {
                echo Yii::$app->controller->renderPartial('@app/modules/Citydescription/views/citydescription/_view', ['data'=>$bc, 'count'=>0]);
            }
            if($morepage) {
                echo Html::a(Yii::t('app','Még több'),  ['/citydescription/countries/view', 'id'=>$model->id, 'title'=>$model->link, 'page'=>'more'], ['class'=>'more-country-btn']);
            }
        ?>

        <div class="country-moreprod">
            <?php
                foreach ($products as $product)
                {
                    echo $this->render('@webroot/modules/Products/views/products/_gridview', ['model'=> $product]);
                }
            ?>
        </div>

        <div class="country-description">
            <?= $model->content ?>
        </div>

        <div class="country-extrainfo">
            <?= $model->extra_info ?>
        </div>
    </div>

</div>