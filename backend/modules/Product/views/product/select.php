<div class="container">
    <div class="row">
<?php

    use kartik\helpers\Html;
    use kartik\icons\Icon;

    foreach ($allProducts as $product){

        ?>


                <div class="col-sm-3 col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon ">
                            <img style="width:200px" src="<?=Yii::$app->fileStorage->baseUrl
                            .$product->thumbnail?>">
                            <?php
\frontend\assets\MdbButtonsAsset::register($this);
                            ?>

                        </span>


                      <div class="info-box-content">
                        <p><?=$product->title?></p>

                          <span class="info-box-number"><?php

                              ?>
                              <a href="/Product/product/blocked?prodId=<?=$product->id?>" class="btn-xs
                              btn-deep-purple"> Block Days</a>
                              <a href="/Product/product/blockedtimes?prodId=<?=$product->id?>" class="btn-xs
                              btn-outline-deep-purple"> Block Times</a>
                              <a href="/Product/product/timetable?prodId=<?=$product->id?>" class="btn-xs
                              btn-deep-purple"> Time Table</a>
                              <a href="/Product/product/update?prodId=<?=$product->id?>" class="btn-xs
                              btn-outline-deep-purple">Edit</a>
                             </span>
                      </div>
                          <!-- /.info-box-content -->
                    </div>
                </div>




        <?php



    }?>
    </div>
</div>
