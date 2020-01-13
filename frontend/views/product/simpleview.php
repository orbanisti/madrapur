<?php
    /* @var $this yii\web\View */

    use backend\modules\Product\models\Product;
    use frontend\models\Modorder;
    use Imagine\Image\ManipulatorInterface;
    use yii\bootstrap4\ActiveForm;
    use yii\bootstrap4\Html;
    use yii\data\ActiveDataProvider;
    use yii\web\View;

    /* @var $model common\models\Article */
    $this->title = $model->title;
    //$this->params['breadcrumbs'][] = [
    //    'label' => Yii::t('frontend', 'Articles'),
    //    'url' => [
    //        'index'
    //    ]
    //];
    //$this->params['breadcrumbs'][] = $this->title;

?>

<?php

    $this->registerJs(
        'objectFitImages();

/* init Jarallax */
jarallax(document.querySelectorAll(\'.jarallax\'));', \yii\web\View::POS_READY

    );
    \frontend\assets\MdbAsset::register($this);
    \common\assets\FontAwesome::register($this);
?>

<?php
    $toggledisplay = <<< SCRIPT

                                    $('.mdb-select').materialSelect();


                                SCRIPT;


    $this->registerJs($toggledisplay, View::POS_READY);
?>

        <!-- Main Container -->
        <div class="container">

            <!-- Section: Product detail -->
            <section id="productDetails" class="pb-5">

                <!-- News card -->
                <div class="card mt-5 hoverable">

                    <div class="row mt-5">

                        <div class="col-lg-6">

                            <!-- Carousel Wrapper -->
                            <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails"
                                 data-ride="carousel">

                                <!-- Slides -->
                                <div class="carousel-inner text-center text-md-left" role="listbox">

                                    <div class="carousel-item active">

                                        <img src="<?=Yii::$app->fileStorage->baseUrl.$model->thumbnail?>"
                                             alt="First slide"

                                             class="img-fluid">

                                    </div>


                                </div>
                                <!-- Slides -->

                                <!-- Thumbnails -->
                                <a class="carousel-control-prev" href="#carousel-thumb" role="button"
                                   data-slide="prev">

                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                                    <span class="sr-only">Previous</span>

                                </a>

                                <a class="carousel-control-next" href="#carousel-thumb" role="button"
                                   data-slide="next">

                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>

                                    <span class="sr-only">Next</span>

                                </a>
                                <!-- Thumbnails -->

                            </div>
                            <!-- Carousel Wrapper -->

                        </div>

                        <div class="col-lg-5 mr-3 text-center text-md-left">

                            <h2
                                    class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">

                                <strong><?= $model->title ?></strong>

                            </h2>

                            <span class="badge badge-danger product mb-4 ml-xl-0 ml-4"><?= $model->category ?></span>

                            <h3 class="h3-responsive text-center text-md-left mb-5 ml-xl-0 ml-4">

              <span class="info text-info font-weight-bold">

                <strong>€49</strong>

              </span>

                                <!--                                    <span class="grey-text">-->
                                <!---->
                                <!--                <small>-->
                                <!---->
                                <!--                  <s>$89</s>-->
                                <!---->
                                <!--                </small>-->
                                <!---->
                                <!--              </span>-->

                            </h3>

                            <!-- Accordion wrapper -->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist"
                                 aria-multiselectable="true">

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1">

                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1"
                                           aria-expanded="true"
                                           aria-controls="collapseOne1">

                                            <h5 class="mb-0 text-info">

                                                Description

                                                <i class="fas fa-angle-down rotate-icon"></i>

                                            </h5>

                                        </a>

                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseOne1" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingOne1"
                                         data-parent="#accordionEx">

                                        <div class="card-body">

                                            <?= $model->description ?>

                                        </div>

                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->

                            </div>
                            <!-- Accordion wrapper -->



                            <!-- Add to Cart -->
                            <section class="color">

                                <div class="mt-5">

                                    <p class="grey-text">Please choose a size:</p>

                                    <div class="col-sm-12 text-center text-md-left">
                                        <?php
                                            $ordermodel=new Modorder();

                                            $buyform = ActiveForm::begin(
                                                [

                                                    'id' => 'buy-form',
                                                    'options' => ['class' => 'modImp'],
                                                ]
                                                    );

                                            $productPrices=$model->getPrices();

                                            echo $buyform->field($ordermodel,'productId')->hiddenInput(['value' => $model->id])->label(false);
                                            echo $buyform->field($ordermodel,'priceId')->dropDownList($productPrices,
                                                                                                      ['class'=>'mdb-select md-form colorful-select dropdown-info'])->label(false);








                                        ?>



                                    </div>

                                    <div class="row mt-3 mb-4">

                                        <div class="col-md-12 text-center text-md-left text-md-right">
<?php

    echo Html::submitButton('<i class="fas fa-cart-plus mr-2" aria-hidden="true"></i>Add to cart', ['class' => 'btn btn-primary btn-rounded']) ;
     ActiveForm::end();

?>
                                        </div>


                                    </div>

                                </div>

                            </section>
                            <!-- Add to Cart -->

                        </div>

                    </div>

                </div>

            </section>

            <!-- Section: Product detail -->
            <div class="divider-new">

                <h3 class="h3-responsive font-weight-bold blue-text mx-3">Product Reviews</h3>

            </div>

            <!-- Product Reviews -->
            <section id="reviews" class="pb-5">

                <!-- Main wrapper -->
                <div class="comments-list text-center text-md-left">

                    <!-- First row -->
                    <div class="row mb-5">

                        <!-- Image column -->
                        <div class="col-sm-2 col-12 mb-3">

                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img (8).jpg" alt="sample image"
                                 class="avatar rounded-circle z-depth-1-half">

                        </div>
                        <!-- Image column -->

                        <!-- Content column -->
                        <div class="col-sm-10 col-12">

                            <a>

                                <h5 class="user-name font-weight-bold">John Doe</h5>

                            </a>

                            <!-- Rating -->
                            <ul class="rating">

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                            </ul>

                            <div class="card-data">

                                <ul class="list-unstyled mb-1">

                                    <li class="comment-date font-small grey-text">

                                        <i class="far fa-clock-o"></i> 05/10/2015
                                    </li>

                                </ul>

                            </div>

                            <p class="dark-grey-text article">Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis

                                aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                                nulla pariatur.
                                Excepteur

                                sint occaecat cupidatat non proident.</p>

                        </div>
                        <!-- Content column -->

                    </div>
                    <!-- First row -->

                    <!-- Second row -->
                    <div class="row mb-5">

                        <!-- Image column -->
                        <div class="col-sm-2 col-12 mb-3">

                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img (30).jpg" alt="sample image"
                                 class="avatar rounded-circle z-depth-1-half">

                        </div>
                        <!-- Image column -->

                        <!-- Content column -->
                        <div class="col-sm-10 col-12">

                            <a>

                                <h5 class="user-name font-weight-bold">Lily Brown</h5>

                            </a>

                            <!-- Rating -->
                            <ul class="rating">

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                            </ul>

                            <div class="card-data">

                                <ul class="list-unstyled mb-1">

                                    <li class="comment-date font-small grey-text">

                                        <i class="far fa-clock-o"></i> 05/10/2015
                                    </li>

                                </ul>

                            </div>

                            <p class="dark-grey-text article">Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis

                                aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                                nulla pariatur.
                                Excepteur

                                sint occaecat cupidatat non proident.</p>

                        </div>
                        <!-- Content column -->

                    </div>
                    <!-- Second row -->

                    <!-- Third row -->
                    <div class="row mb-5">

                        <!-- Image column -->
                        <div class="col-sm-2 col-12 mb-3">

                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img (28).jpg" alt="sample image"
                                 class="avatar rounded-circle z-depth-1-half">

                        </div>
                        <!-- Image column -->

                        <!-- Content column -->
                        <div class="col-sm-10 col-12">

                            <a>

                                <h5 class="user-name font-weight-bold">Martha Smith</h5>

                            </a>

                            <!-- Rating -->
                            <ul class="rating">

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                                <li>

                                    <i class="fas fa-star blue-text"></i>

                                </li>

                            </ul>

                            <div class="card-data">

                                <ul class="list-unstyled mb-1">

                                    <li class="comment-date font-small grey-text">

                                        <i class="far fa-clock-o"></i> 05/10/2015
                                    </li>

                                </ul>

                            </div>

                            <p class="dark-grey-text article">Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis

                                aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                                nulla pariatur.
                                Excepteur

                                sint occaecat cupidatat non proident.</p>

                        </div>
                        <!-- Content column -->

                    </div>
                    <!-- Third row -->

                </div>
                <!-- Main wrapper -->

            </section>

            <!-- Product Reviews -->
            <div class="divider-new">

                <h3 class="h3-responsive font-weight-bold blue-text mx-3">Related Products</h3>

            </div>

            <!-- Section: Products v.5 -->
            <section id="products" class="pb-5">

                <p class="text-center w-responsive mx-auto mb-5 dark-grey-text">Lorem ipsum dolor sit amet,
                    consectetur
                    adipisicing elit. Fugit, error amet numquam iure provident voluptate esse quasi,

                    veritatis totam voluptas nostrum quisquam eum porro a pariatur accusamus veniam.</p>

                <!-- Carousel Wrapper -->
                <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                    <!-- Controls -->
                    <div class="controls-top">

                        <a class="btn-floating primary-color" href="#multi-item-example" data-slide="prev">

                            <i class="fas fa-chevron-left"></i>

                        </a>

                        <a class="btn-floating primary-color" href="#multi-item-example" data-slide="next">

                            <i class="fas fa-chevron-right"></i>

                        </a>

                    </div>
                    <!-- Controls -->

                    <!-- Indicators -->
                    <ol class="carousel-indicators">

                        <li class="primary-color" data-target="#multi-item-example" data-slide-to="0"
                            class="active"></li>

                        <li class="primary-color" data-target="#multi-item-example" data-slide-to="1"></li>

                        <li class="primary-color" data-target="#multi-item-example" data-slide-to="2"></li>

                    </ol>
                    <!-- Indicators -->

                    <!-- Slides -->
                    <div class="carousel-inner" role="listbox">

                        <!-- First slide -->
                        <div class="carousel-item active">

                            <div class="col-md-4 mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/14.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Sony TV-675i</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-danger mb-2">bestseller</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star grey-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/13.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Samsung 786i</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-info mb-2">new</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star grey-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/9.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Canon 675-D</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-danger mb-2">bestseller</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                        </div>
                        <!-- First slide -->

                        <!-- Second slide -->
                        <div class="carousel-item">

                            <div class="col-md-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/8.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Samsung V54</a>

                                            </strong>

                                        </h5>

                                        <span class="badge grey mb-2">best rated</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/5.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Dell V-964i</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-info mb-2">new</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/1.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">iPad PRO</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-danger mb-2">bestseller</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star grey-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                        </div>
                        <!-- Second slide -->

                        <!-- Third slide -->
                        <div class="carousel-item">

                            <div class="col-md-4 mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/12.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>

                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Asus CT-567</a>

                                            </strong>

                                        </h5>

                                        <span class="badge grey mb-2">best rated</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/7.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Dell 786i</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-info mb-2">new</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star grey-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                            <div class="col-md-4 clearfix d-none d-md-block mb-4">

                                <!-- Card -->
                                <div class="card card-ecommerce">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/10.jpg"
                                             class="img-fluid"
                                             alt="">

                                        <a>

                                            <div class="mask rgba-white-slight"></div>

                                        </a>

                                    </div>
                                    <!-- Card image -->

                                    <!-- Card content -->
                                    <div class="card-body">

                                        <!-- Category & Title -->
                                        <h5 class="card-title mb-1">

                                            <strong>

                                                <a href="" class="dark-grey-text">Headphones</a>

                                            </strong>

                                        </h5>

                                        <span class="badge badge-info mb-2">new</span>

                                        <!-- Rating -->
                                        <ul class="rating">

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                            <li>

                                                <i class="fas fa-star blue-text"></i>

                                            </li>

                                        </ul>

                                        <!-- Card footer -->
                                        <div class="card-footer pb-0">

                                            <div class="row mb-0">

                      <span class="float-left">

                        <strong>1439$</strong>

                      </span>

                                                <span class="float-right">

                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">

                          <i class="fas fa-shopping-cart ml-3"></i>

                        </a>

                      </span>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->

                            </div>

                        </div>
                        <!-- Third slide -->

                    </div>
                    <!-- Slides -->

                </div>
                <!-- Carousel Wrapper -->

            </section>
            <!-- Section: Products v.5 -->

        </div>
        <!-- Main Container -->

<?php
?>
