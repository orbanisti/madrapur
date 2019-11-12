<?php
\frontend\assets\MdbButtonsAsset::register($this);
?>



<div class="card">
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

                foreach ($allTicketBlocks as $ticketblock):
            ?>
            <li class="item">
                <div class="product-img">
                    <i class="fas fa-book fa-3x "></i>
                </div>
                <div class="product-info">
                    <a href="/Tickets/tickets/view-block?ticketBlockStartId=<?=$ticketblock->startId?>"
                       class="product-title"><?=$ticketblock->startId?>
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
                        Current ticket Id : <span><?=$ticketblock->returnCurrentId()?></span>
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



