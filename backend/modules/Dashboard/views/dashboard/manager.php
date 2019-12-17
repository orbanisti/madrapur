<?php
\frontend\assets\MdbButtonsAsset::register($this);
?>



<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Assigned Ticket Blocks</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">

            <?php

                use backend\modules\Tickets\models\TicketBlock;
                use yii\bootstrap4\Html;

                foreach ($myTicketBlocks as $ticketblock):
            ?>
            <li class="item">
                <div class="product-img">
                    <i class="fas fa-book fa-3x "></i>
                </div>
                <div class="product-info">
                    <a href="/Tickets/tickets/view-block?ticketBlockStartId=<?=$ticketblock->startId?>"
                       class="product-title"><?=$ticketblock->startId?></a>
                      <?php
                            if(!$ticketblock->isActive){
                                echo Html::a('Activate',
                                             '/Dashboard/dashboard/manager?changeTo='.$ticketblock->startId,
                                             [
                                                 'title' => Yii::t('backend', 'Activate'),
                                                 'class'=>' float-right btn bg-gradient-success'
                                             ]);

                            }
                            else{



                                echo Html::a('<i class="fas fa-check-double  "></i>'.'Active',
                                             '/Dashboard/dashboard/admin?skip-ticket='.TicketBlock::userNextTicketId(),
                                             [
                                                 'title' => Yii::t('backend', 'Activate'),
                                                 'class'=>'disabled float-right btn bg-success'
                                             ]);

                            }


                            ?></a>
                    <span class="product-description">
                        Current: <span><?=$ticketblock->returnCurrentId()?></span>
                      </span>
                </div>
            </li>
            <?php
                endforeach;
            ?>
            <!-- /.item -->

            <!-- /.item -->
        </ul>
    </div>
    <!-- /.card-body -->

    <!-- /.card-footer -->
</div>

<?php
if(Yii::$app->user->can('streetAdmin')) {
    ?>



            <?php

                foreach ($allTicketHolders as $ticketHolder) {
                    $user = \common\models\User::findOne($ticketHolder);
                    ?>
                    <div class="card collapsed-card card-info">
                        <div class="card-header" >
                            <div class="card-title" data-card-widget="collapse">
                                <?= $user->username ?>
                            </div>
                            <div class="card-tools">
                                <a class="btn-tool btn" href="/Tickets/tickets/add-block?user=<?=$user->id?>">add</a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>

                            </div>

                        </div>
                        <div class="card-body">

                            <ul class="products-list product-list-in-card pl-2 pr-2">

                                <?php

                                    foreach ($allTicketBlocks as $ticketblock):
                                        if ($user->id != $ticketblock->assignedTo) continue
                                        ?>
                                        <li class="item">
                                            <div class="product-img">
                                                <i class="fas fa-book fa-3x "></i>
                                            </div>
                                            <div class="product-info">
                                                <a href="/Tickets/tickets/view-block?ticketBlockStartId=<?= $ticketblock->startId ?>"
                                                   class="product-title"><?= $ticketblock->startId ?>
                                                    <?php
                                                        if (!$ticketblock->isActive) {

                                                        } else {

                                                            echo '<i class="fas fa-check-double  "></i>';
                                                        }

                                                    ?></a>
                                                <span class="product-description">
                        Current: <span><?= $ticketblock->returnCurrentId() ?></span>
                      </span>
                                            </div>
                                        </li>
                                    <?php
                                    endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>

                    <?php

                } ?>


            <!-- /.item -->

            <!-- /.item -->


        <!-- /.card-body -->

        <!-- /.card-footer -->

    <?php
}
    ?>