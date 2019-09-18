<?php

use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

?>


<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Add ticket block
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="card-body">

        <div class="panel">
            <div class="panel-body">
                <?php

                    $form = ActiveForm::begin([
                        'id' => 'add-ticket-block',
                        'class' => 'form-inline'
                    ]);

                ?>

                <div class="form-group">
                    <?=
                        $form->field($model, 'startId', [
                            'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group"><span class="input-group-text">ID</span>{input}</div>{error}{hint}',
                            'hintType' => \kartik\form\ActiveField::HINT_DEFAULT,
                            'hintSettings' => [
                                'onLabelClick' => false,
                                'onLabelHover' => true,
                                'onIconHover' => true,
                            ]
                        ])->textInput([
                            'placeholder' => 'First ID.',
                            'name' => 'startId',
                            'id' => 'startId',
                            'maxlength' => 8,
                            //'pattern' => '\d*',
                            'required' => true
                        ])->hint('Entering the full ticket ID is mandatory. In case of voucher ticket block include the initial letter, too.')
                    ?>
                </div>

                <div class="form-group">
                    <script type='text/javascript'>
                        var avatars = <?= $avatars ?>;
                    </script>

                    <?php
                        $this->registerJs(<<< SCRIPT

function format(state) {
    if (!state.id) return state.text;
    src = avatars[state.id.toLowerCase()];
    return '<img class="flag" style="width: 20px; height: 20px;" src="' + src + '"/>' + state.text;
}

SCRIPT
                            , View::POS_HEAD);
                    ?>

                    <?= $form->field($model, 'assignedTo')->widget(Select2::class, [
                        'name' => 'assignedTo',
                        'data' => $users,
                        'options' => [
                            'placeholder' => 'Select a user.',
                            'required' => true
                        ],
                        'pluginOptions' => [
                            'templateResult' => new JsExpression('format'),
                            'templateSelection' => new JsExpression('format'),
                            'escapeMarkup' => new JsExpression("function escape(m) { return m; }"),
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>

                <?= Html::submitButton(
                    Yii::t('backend', 'Add ticket block'),
                    [
                        'class' => 'btn btn-primary btn-flat btn-block',
                        'name' => 'add-ticket-block-button'
                    ]
                );

                ?>

                <?php ActiveForm::end() ?>
            </div>
        </div>

    </div>
    <!-- /.card-body-->
</div>

