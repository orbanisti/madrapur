<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Issuerequest\models\IssuerequestSearch $searchModel
 */
?>
<div class="card">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            To Do List
        </h3>

        <div class="card-tools">

        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list ui-sortable" data-widget="todo-list">

            <?php
                foreach($dataProvider->models as $issue){

                    switch($issue->priority){
                        case 'High':
                            $badgeClass='badge-danger';
                            break;
                        case 'Medium':
                            $badgeClass='badge-warning';
                            break;
                        case 'Low':
                            $badgeClass='badge-info';


                    }

                    ?>

                    <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="<?=$issue->id?>" id="<?=$issue->id?>">
                            <label for="<?=$issue->id?>"></label>
                        </div>
                        <?=Html::a(" <span class=\"text\">$issue->content</span>", ['view', 'id' => $issue->id])?>


                        <small class="badge <?=$badgeClass?>"><i class="far fa-clock"></i><?=date('Y-m-d H:i',
                                                                                                  $issue->createdAt)
                            ?></small>   <small class="badge <?=$badgeClass?>"><?=$issue->category?></small> <small
                                class="badge <?=$badgeClass?>"><?=\common\models\User::findIdentity
                            ($issue->createdBy)->username?></small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash"></i>
                        </div>
                    </li>

                    <?php

                }


            ?>



        </ul>
    </div>
    <!-- /.card-body -->

</div>

