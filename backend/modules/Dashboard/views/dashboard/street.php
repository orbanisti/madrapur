<?php

    use backend\modules\Modevent\models\Modevent;
    use backend\modules\Modevent\models\Workshift;
    use backend\modules\Tickets\models\TicketBlock;
    use yii\bootstrap4\ActiveForm;
    use yii\bootstrap4\Html;

?>
<div class="row">
    <div class="col-12">

        <!-- interactive chart -->
        <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Hello, <strong ><?=

                            Yii::$app->user->getIdentity()
                            ->username?></strong>
                </h3>

            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="<?=\common\models\UserProfile::findOne
                (Yii::$app->user->id)
                    ->getAvatar() ? \common\models\UserProfile::findOne
                (Yii::$app->user->id)
                    ->getAvatar() : '/img/anonymous.jpg'?>"
                     alt="User
                Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <div class="small-box bg-gradient-info">
                                <div class="inner">


                                        <?php

                                            $nextWork=Modevent::userNextWork();

                                            switch ($nextWork){

                                                case null:
                                                    echo ' <h3>None, please subscribe first</h3>';
                                                    echo '  <p>Next Work</p>'.Html::a('Subscribe for Work <i class="fas fa-pen-fancy  
                                                    "></i>',
                                                                 '/Modevent/modevent/subscribe',
                                                                 [
                                                                     'title' => Yii::t('backend', 'Login'),
                                                                     'class'=>'btn bg-info'
                                                                 ]);
                                                    break;

                                                case !(null):


                                                    $workShift=Workshift::findOne($nextWork->place);

                                                    echo '<h3>'.$workShift->place
                                                        .'</h3>';
                                                    echo '<p><span class="badge-pill badge-primary">'.$workShift->role.'</span><span class="badge-pill badge-primary">'
                                                        .date('H:i',
                                                                                                            strtotime
                                                        ($workShift->startTime)).' - '.date
                                                        ('H:i',strtotime($workShift->endTime)). '</span></p>';
                                                        $form=ActiveForm::begin(['action' =>
                                                                                 ['/Modevent/modevent/mywork']]);



                                                    if($nextWork->title=='arranged' && $nextWork->status==null) {
                                                        echo Html::submitButton(
                                                            Yii::t('backend', 'Start working' . '<i class="fas fa-running fa-fw "></i>'),
                                                            [
                                                                'class' => 'btn bg-gradient-primary',
                                                                'name' => 'work',
                                                                'value' => $nextWork->id,

                                                            ]
                                                        );

                                                    }
                                                    elseif($nextWork->status=='working'){
                                                        echo Html::submitButton(
                                                            Yii::t('backend', 'Let\'s finish working' . '<i class="fas fa-running fa-fw
                                            "></i>'),
                                                            [
                                                                'class' => 'btn btn-success btn-flat',
                                                                'name' => 'work-end',
                                                                'value' => $nextWork->id
                                                            ]
                                                        );

                                                    }
                                                    elseif($nextWork->status=='worked'){
                                                        echo Html::submitButton(
                                                            Yii::t('backend', 'Job Done, Good work!' . '<i class="fas fa-thumbs-up fa-fw "></i>'),
                                                            [
                                                                'class' => 'disabled btn btn-success btn-flat',
                                                                'name' => 'work-end',
                                                                'value' => $nextWork->id
                                                            ]
                                                        );

                                                    }



                                                    ActiveForm::end();
                                            }

                                        ?>


                                </div>
                                <div class="icon">
                                    <i class="fas fa-ticket-alt  "></i>
                                </div>


                            </div>

                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= TicketBlock::userNextTicketId()?>
                                    </h3>

                                    <p>Next Ticket ID</p>
                                    <?=Html::a('Change Ticket Block <i class="fas fa-book  "></i>',
                                               '/Dashboard/dashboard/manager',
                                               [
                                                   'title' => Yii::t('backend', 'Login'),
                                                   'class'=>'btn bg-gradient-primary'
                                               ])
                                    ?>
                                    <?=Html::a('Skip Ticket <i class="fas fa-arrow-circle-right"></i>',
                                               '/Dashboard/dashboard/admin?skip-ticket='.TicketBlock::userNextTicketId(),
                                               [
                                                   'title' => Yii::t('backend', 'Login'),
                                                   'class'=>'btn bg-gradient-primary'
                                               ])
                                    ?>
                                </div>



                                <div class="icon">
                                    <i class="fas fa-ticket-alt  "></i>
                                </div>
                            </div>
                         </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tree  "></i>
                    My work

                </h3>

                <div class="card-tools">


                </div>
            </div>
            <div id="" class="card-body">

                <?php

                    echo $this->render('mywork',['date'=>date('Y-m-d',time())]);
                ?>
               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>

<?php


  ?>