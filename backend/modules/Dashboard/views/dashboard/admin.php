<h1>admin</h1>
<div class="col-xs-12 col-md-3">
    <?php

        use insolita\adminlte3\LteSmallBox;
        use insolita\wgadminlte\LteConst;
    use yii\helpers\Url;

    LteSmallBox::begin([
        'type' => LteConst::COLOR_TEAL,
        'title' => "",
        'text' => ' ',
        'icon' => 'fa fa-ticket',
        'footer' => 'View ticket block',
        'link' => Url::to('Tickets/tickets/admin')
    ]) ?>
    <?php LteSmallBox::end() ?>

    <?php
    LteSmallBox::begin([
        'type' => LteConst::COLOR_TEAL,
        'title' => "",
        'text' => ' ',
        'icon' => 'fa fa-ticket',
        'text' => 'Next ticked ID',
        'footer' => 'View ticket block',
        'link' => Url::to('Tickets/tickets/admin')
    ]) ?>
    <?php LteSmallBox::end() ?>

    <?php
    LteSmallBox::begin([
        'type' => LteConst::COLOR_TEAL,
        'title' => "",
        'text' => ' ',
        'icon' => 'fa fa-ticket',
        'text' => 'Next ticked ID',
        'footer' => 'View ticket block',
        'link' => Url::to('Tickets/tickets/admin')
    ]) ?>
    <?php LteSmallBox::end() ?>
</div>