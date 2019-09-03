<?php

use insolita\wgadminlte\LteConst;
use insolita\wgadminlte\LteSmallBox;
use yii\helpers\Url;

?>
<h1>Hotline</h1>

<div class="col-xs-12 col-md-3">
    <?php
    LteSmallBox::begin([
        'type' => LteConst::COLOR_TEAL,
        'title' => "$nextTicketId",
        'text' => ' ',
        'icon' => 'fa fa-ticket',
        'text' => 'Next ticked ID',
        'footer' => 'View ticket block',
        'link' => Url::to("/Tickets/tickets/admin")
    ])::end();
    ?>
</div>