<?php
    /**
     * @var $this yii\web\View
     * @var $model common\models\Article
     */

    use yii\helpers\Html;

?>
<hr/>
<div class="row">
    <!--Image column-->
    <div class="col-2 ">
        <i class="fas fa-user-circle fa-3x "></i>
    </div>
    <!--/.Image column-->

    <!--Content column-->
    <div class="col-10">
        <a>
            <h5 class="user-name font-weight-bold"><?= $model->author ?></h5>
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
                    <i class="far fa-clock-o"></i> 2 days ago
                </li>
            </ul>
        </div>
        <p class="dark-grey-text article"><?= $model->content ?></p>
    </div>
    <!--/.Content column-->
</div>

