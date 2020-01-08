<?php

    use common\models\User;
    use common\models\UserProfile;
    use yii\helpers\Html;
    //\backend\assets\MaterializeWidgetsAsset::register($this);


?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-eye-slash  fa-fw "></i>
                    Peeper
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Today's Workers</h3>

                            <div class="card-tools">
                                <span class="badge badge-danger"><?=count($modevents)?> signed up to work today</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">


                            <ul class="users-list clearfix">
                                <?php
                                    foreach($modevents as $user){

                                        $userModel= User::findByUsername($user->user);

                                        $userAvatar= UserProfile::findOne($userModel->id)->getAvatar();
                                        ?>
                                        <li>
                                            <img class="img-circle elevation-2" src="<?=$userAvatar ? $userAvatar : '/img/anonymous.jpg' ?>"
                                                 alt="User Image">
                                            <a class="users-list-name" href="#"><?=$userModel->username?></a>
                                            <span class="users-list-date
                                        bg-gradient-white"><span class="badge-pill badge-info">
                                                    <?=($workshift=\backend\modules\Modevent\models\Workshift::findOne
                                                        ($user->place))
                                                            ->place.'</span><br/><span class="badge-pill badge-info"> 
                                                            '.$workshift->startTime." - 
                                                            "
                                                    .$workshift->endTime
                                                    ?></span> </span>

                                            <span class="badge-pill <?=$user->status ?
                                                'badge-success' : 'badge-danger' ?>"><?=$user->status ?
                                                    $user->status:
                                                    'not started yet'
                                                ?></span>
                                        </li>

                                        <?php

                                    }


                                ?>


                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="<?=\yii\helpers\Url::to(['modevent/calendar'])?>">View calendar</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>

                </div>
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>
