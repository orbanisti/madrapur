<?php
/* @var $this yii\web\View */

    use Imagine\Image\ManipulatorInterface;
    use yii\bootstrap4\Html;
    use yii\data\ActiveDataProvider;

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
jarallax(document.querySelectorAll(\'.jarallax\'));',\yii\web\View::POS_READY

    );
\frontend\assets\MdbAsset::register($this);
\common\assets\FontAwesome::register($this);
?>
<div class="container">


    <div class="row">
        <div class="col-12">
            <!-- interactive chart -->

            <!-- Card image -->
            <?php


                $thumbnail=Yii::$app->fileStorage->baseUrl.$model->thumbnail;
                $items = [
                    [
                        'url' => $thumbnail,
                        'src' => $thumbnail,
                        'options' => ['alt' => $model->title]
                    ],[
                        'url' => $thumbnail,
                        'src' => $thumbnail,
                        'options' => ['alt' => $model->title]
                    ]
                ];
                $this->registerJs("$(function() {
   $('#popupModal').click(function(e) {
    console.log('megyek');
     e.preventDefault();
     $('#basicExampleModal').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});");

            ?>


            <!-- Card content -->
            <style>
                img{
                    max-width:100%;
                }
                h1{
                    padding:10px;
                }
                .carousel-control-prev-icon,
                .carousel-control-next-icon {
                    height: 100px;
                    width: 100px;
                    outline: black;
                    background-size: 100%, 100%;
                    border-radius: 50%;
                    background-image: none;

                }

                .carousel-control-next-icon:after
                {
                    content: '>';
                    font-size: 55px;
                    color: lightgrey;
                }

                .carousel-control-prev-icon:after {
                    content: '<';
                    font-size: 55px;
                    color: lightgrey;
                }



            </style>

            <!-- Title -->
            <!-- Subtitle -->
            <div class="content">
                <article class="article-item">
                    <header>                    <h1 class="h1-responsive"><?=$model->title?> <i class="fas fa-sm

                    fa-star
purple-text">4.8</i> </h1>

                    </header>

                    <img src="<?=$thumbnail?>">

                    <div class="container">
                        <div class="row">
                            <span style="background:#eee;margin: 3px;" class="badge-pill"><i class="fas fa-ship
                            purple-text"></i>New Ship</span>
                            <span style="background:#eee;margin: 3px;" class="badge-pill"><i class="fas fa-ship
                            purple-text "></i>75
                                Minutes</span>
                            <span style="background:#eee;margin: 3px;" class="badge-pill"><i class="fas fa-ship
                            purple-text"></i>Audio
                                Guides</span>
                            <span style="background:#eee;margin: 3px;" class="badge-pill"><i class="fas fa-wifi
                            purple-text"></i>Free Wifi</span>
                            <span style="background:#eee;margin: 3px;" class="badge-pill"><i class="fas fa-camera
                            purple-text"></i>Open Deck</span>

                        </div>
                        <div class="row">
                            <!-- Button trigger modal -->
                            <button type="button" style="width:100%" id="popupModal" class="btn btn-deep-purple "
                                    data-toggle="modal"
                                    href="/Reservations/reservations/remotebook?id=<?=$model->id?>"
                                    data-target="#basicExampleModal">
                                Book Now
                            </button>
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion " style="width: 100%" id="accordionEx" role="tablist"
                                 aria-multiselectable="true">

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1" >
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                                           aria-controls="collapseOne1">
                                            <h5 class="purple-text">
                                                456 Reviews <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                                         data-parent="#accordionEx">
                                        <div class="card-body ">

                                            <?php
                                                $testimonials=\backend\modules\Product\models\Review::find()->all();
                                                foreach($testimonials as $testimonial) {

                                                    $reviews[] = "   <div class=\"row \">
                                                <!--Image column-->
                                                <div class=\"col-2 \">
                                                    <i class=\"fas fa-user-circle fa-3x \"></i>
                                                </div>
                                                <!--/.Image column-->

                                                <!--Content column-->
                                                <div class=\"col-10\">
                                                    <a>
                                                        <h5 class=\"user-name font-weight-bold\">$testimonial->author</h5>
                                                    </a>
                                                    <!-- Rating -->
                                                    <ul class=\"rating\">
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                    </ul>
                                                    <div class=\"card-data\">
                                                        <ul class=\"list-unstyled mb-1\">
                                                            <li class=\"comment-date font-small grey-text\">
                                                                <i class=\"far fa-clock-o\"></i> 2 days ago</li>
                                                        </ul>
                                                    </div>
                                                    <p class=\"dark-grey-text article\">$testimonial->content</p>
                                                </div>
                                                <!--/.Content column-->
                                            </div>";
                                                }
                                                echo \yii\bootstrap4\Carousel::widget(['items' => $reviews]);

                                                $query = \backend\modules\Product\models\Review::find()
                                                    ->andFilterWhere(['>','id',2]);

                                                $dataProvider = new ActiveDataProvider([
                                                                                           'query' => $query,
                                                                                           'pagination' => ['pageSize'=>1],

                                                                                       ]);
                                               echo  \yii\grid\GridView::widget([

                                                        'dataProvider' => $dataProvider,
                                                        'summary' => '',
                                                        'columns' => [
                                                            [
                                                                'format' => 'raw',
                                                                'value' => function($model,$key,$index,$widget){
                                                                    return " <div class=\"row \">
                                                <!--Image column-->
                                                <div class=\"col-2 \">
                                                    <i class=\"fas fa-user-circle fa-3x \"></i>
                                                </div>
                                                <!--/.Image column-->

                                                <!--Content column-->
                                                <div class=\"col-10\">
                                                    <a>
                                                        <h5 class=\"user-name font-weight-bold\">$model->author</h5>
                                                    </a>
                                                    <!-- Rating -->
                                                    <ul class=\"rating\">
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                        <li>
                                                            <i class=\"fas fa-star blue-text\"></i>
                                                        </li>
                                                    </ul>
                                                    <div class=\"card-data\">
                                                        <ul class=\"list-unstyled mb-1\">
                                                            <li class=\"comment-date font-small grey-text\">
                                                                <i class=\"far fa-clock-o\"></i> 2 days ago</li>
                                                        </ul>
                                                    </div>
                                                    <p class=\"dark-grey-text article\">$model->content</p>
                                                </div>
                                                <!--/.Content column-->
                                            </div>";

                                                                }

                                                            ],



                                                        ],

                                                        'pager' => [
                                                                'class'=>\sjaakp\loadmore\LoadMorePager::class,
                                                                'id'=>'reviews',
                                                                'options' => [
                                                                        'class'=>'btn btn-outline-purple',
                                                                        'style'=>'width:100%;'

                                                                ]

                                                        ]
                                                                                   ]);



                                            ?>

                                        </div>
                                    </div>

                                </div>
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1" >
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne2"
                                           aria-expanded="true"
                                           aria-controls="collapseOne2">
                                            <h5 class="purple-text">
                                                Description <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseOne2" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingOne2"
                                         data-parent="#accordionEx">
                                        <div class="card-body ">

                                            <?php echo $model->description ?>
                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->

                                <!-- Accordion card -->

                                <!-- Accordion card -->

                                <!-- Accordion card -->

                            </div>
                            <!-- Accordion wrapper -->
                            <!-- Modal -->
                            <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button  type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php if (!empty($model->articleAttachments)): ?>
                        <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
                        <ul id="article-attachments">
                            <?php foreach ($model->articleAttachments as $attachment): ?>
                                <li>
                                    <?php

                                        echo \yii\helpers\Html::a($attachment->name, [
                                            'attachment-download',
                                            'id' => $attachment->id
                                        ])?>
                                    (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </article>
            </div>

            <!-- /.card -->

        </div>

        <!-- /.col -->
    </div>
</div>
<?php
    ?>
