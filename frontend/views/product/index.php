<?php
    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */
    /* @var $searchModel frontend\models\search\ArticleSearch */
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    \frontend\assets\MdbAsset::register($this);
    \common\assets\FontAwesome::register($this);
    $this->title = Yii::t('frontend', 'Products')?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- interactive chart -->
            <div class="card  card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <?=$this->title?>
                    </h3>


                </div>
                <div class="card-body">


                    <div id="article-index">

                        <span class="glyphicon glyphicon-search" data-toggle="collapse"
                              data-target="#search-form"></span>
                        <div class="collapse" id="search-form">
                            <?php

                                $form = ActiveForm::begin([
                                                              'method' => 'GET',
                                                              'options' => [
                                                                  'class' => 'form-inline'
                                                              ]
                                                          ])?>
                            <div>
                                <?php echo $form->field($searchModel, 'title')->label(false)->error(false) ?>
                                <?php echo Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-default']) ?>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                        <?php

                            echo \yii\widgets\ListView::widget(
                                [
                                    'dataProvider' => $dataProvider,
                                    'pager' => [
                                        'hideOnSinglePage' => true,
                                    ],
                                    'itemView' => '_item'
                                ])?>
                    </div>


                </div>
                <!-- /.card-body-->
            </div>
            <!-- /.card -->

        </div>

        <!-- /.col -->
    </div>
</div>
