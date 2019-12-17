<?php

    use backend\modules\Modevent\models\Workshift;
    use kartik\datecontrol\DateControl;
    use kartik\detail\DetailView;
    use kartik\form\ActiveForm;
    use kartik\icons\Icon;
    use kartik\select2\Select2;
    use kartik\time\TimePicker;
    use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Modevent\models\ModeventSearch $searchModel
 */

?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="timeline">
            <?php

                foreach($toprint as $work) {
                    $workshift = Workshift::findOne($work->place);

                    if(!isset($lastDate) || $lastDate!=$work->startDate){
                        ?>
                        <div class="time-label">
                            <span class="bg-gradient-olive"><?=$work->startDate?></span>
                        </div>


                        <?php

                    }

                    $lastDate=$work->startDate;
                    $duration=date('H:i',strtotime($workshift->startTime))."-".date('H:i',strtotime($workshift->endTime));
                    ?>

                    <div>
                        <?php
                            if($work->status=='worked') {
                                echo '<i class="fas fa-check fa-sm bg-gradient-info "></i>';
                            }
                            else{
                                echo '<i class="fas fa-briefcase fa-sm bg-gradient-info "></i>';
                            }
                        ?>

                        <div class="timeline-item">

                    <span class="float-left text-white text-xl-center bg-info time"><i class="fas fa-clock"></i>
                                            <?= $duration?></span>
                            <h3 class="timeline-header disabled bg-info"><?=$workshift->role?></h3>
                            <div class="timeline-body"><?=$workshift->place?>
                                <?php
                                 $form=ActiveForm::begin();
                                    if($work->title=='arranged' && $work->status==null) {
                                        echo Html::submitButton(
                                            Yii::t('backend', 'Start working' . '<i class="fas fa-running fa-fw "></i>'),
                                            [
                                                'class' => 'btn btn-primary btn-flat',
                                                'name' => 'work',
                                                'value' => $work->id
                                            ]
                                        );
                                    }
                                    elseif($work->status=='working'){
                                        echo Html::submitButton(
                                            Yii::t('backend', 'Let\'s finish working' . '<i class="fas fa-running fa-fw 
                                            "></i>'),
                                            [
                                                'class' => 'btn btn-success btn-flat',
                                                'name' => 'work-end',
                                                'value' => $work->id
                                            ]
                                        );

                                    }
                                    elseif($work->status=='worked'){
                                        echo Html::submitButton(
                                            Yii::t('backend', 'Job Done, Good work!' . '<i class="fas fa-thumbs-up fa-fw "></i>'),
                                            [
                                                'class' => 'disabled btn btn-success btn-flat',
                                                'name' => 'work-end',
                                                'value' => $work->id
                                            ]
                                        );

                                    }
                                   ActiveForm::end();
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <div>
                <i class="fas fa-clock bg-gray"></i>

            </div>
        </div>



        <!-- /.col -->
</div>



