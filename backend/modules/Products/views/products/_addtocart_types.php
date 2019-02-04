 <?phpbackend\
 use app\modules\Products\models\Products;

 if(/*!$model->expired && */$model->source==Products::SOURCE_MANDELAN && $model->enquire_only==0) { ?>
    <div class="product-arrow-row">
        <div class="arrow-btn"></div>
        <div class="arrow-btn"></div>
        <div class="arrow-btn"></div>
        <div class="arrow-btn">
            <div class="<?= (empty($model->times))?'add-cartbg':'add-cartbg-time' ?>">
                <div class="row text-uppercase">
                <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_addtocart', ['product' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php } elseif(/*!$model->expired &&*/ $model->source==Products::SOURCE_MANDELAN && $model->enquire_only==1) { ?>
        <div class="product-arrow-row">
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn">
                <div class="grayline-btns">
                    <div class="row text-uppercase">
                    <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_enquire_btns', ['product' => $model]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif(/*$model->start_date<=date('Y-m-d') && $model->end_date>=date('Y-m-d') && */$model->source==Products::SOURCE_GRAYLINE) { ?>
        <div class="product-arrow-row">
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn">
                <div class="grayline-btns">
                    <div class="row text-uppercase">
                    <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_grayline_btns', ['product' => $model]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif($model->source==Products::SOURCE_TIQETS) { ?>
        <div class="product-arrow-row">
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn">
                <div class="grayline-btns">
                    <div class="row text-uppercase">
                    <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_tiqets_btns', ['product' => $model]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif($model->source==Products::SOURCE_GADVENTURERS) { ?>
        <div class="product-arrow-row">
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn"></div>
            <div class="arrow-btn">
                <div class="grayline-btns">
                    <div class="row text-uppercase">
                    <?= Yii::$app->controller->renderPartial('@app/modules/Products/views/products/_enquire_btns', ['product' => $model]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>