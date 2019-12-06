<div class="container">
    <div class="row">
<?php

    use kartik\helpers\Html;
    use kartik\icons\Icon;

\frontend\assets\MdbButtonsAsset::register($this);



    foreach ($allProducts as $product){

        ?>


                <div class="col-sm-3 col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon ">
                            <img style="width:200px" src="<?=Yii::$app->fileStorage->baseUrl
                            .$product->thumbnail?>">
                            <?php
                                Yii::error($product->thumbnail)
                            ?>

                        </span>


                      <div class="info-box-content">
                        <p><?=$product->title?></p>

                          <span class="info-box-number"><?php

                              ?>
                              <a href="/Product/product/blocked?prodId=<?=$product->id?>" class="btn text-white  btn-xs
                              btn-deep-purple"><i class="fa fa-stop-circle" aria-hidden="true"></i> Block Days</a>
                              <a href="/Product/product/blockedtimes?prodId=<?=$product->id?>" class="btn text-white  btn-xs
                              btn-deep-purple"><i class="fa fa-clock" aria-hidden="true"></i> Block Times</a>
                              <a href="/Product/product/timetable?prodId=<?=$product->id?>" class="btn text-white  btn-xs
                              btn-deep-purple"><i class="fa fa-calendar" aria-hidden="true"></i> Time Table</a>
                              <a href="/Product/product/update?prodId=<?=$product->id?>" class="btn text-white  btn-xs
                              btn-deep-purple"><i class="fa fa-pencil-alt" aria-hidden="true"></i>  Edit</a>
                             </span>
                      </div>
                          <!-- /.info-box-content -->
                    </div>
                </div>




        <?php



    }?>
    </div>
</div>
