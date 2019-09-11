<h1>Seller</h1>
<div class="col-xs-12 col-md-3">
    <?php

    /**
     * @var $nextTicketId
     * @var $startTicketId
     */

    use insolita\wgadminlte\LteConst;
    use insolita\wgadminlte\LteSmallBox;
    use yii\helpers\Url;

    LteSmallBox::begin([
        'type' => LteConst::COLOR_TEAL,
        'title' => "<a style href='".Url::to("/Tickets/tickets/view-ticket?id=$nextTicketId&blockId=$startTicketId")."'>$nextTicketId</a>",
        'icon' => 'fa fa-ticket',
        'text' => 'Next ticked ID',
        'footer' => 'View ticket block',
        'link' => Url::to("/Tickets/tickets/view-block?ticketBlockStartId=$startTicketId")
    ])::end();

    ?>

    <a href="<?= Url::to("/Dashboard/dashboard/admin?skip-ticket=$nextTicketId") ?>" class="btn btn-block btn-primary btn-lg">Skip current ticket</a>

    <a href="<?= Url::to("/Dashboard/dashboard/admin?change-ticket-block=$startTicketId") ?>" class="btn btn-block btn-primary btn-lg">Change Ticket Block</a>

    <style>
        .btn-floating-right-bottom {
            position: fixed !important;
            right: 20px;
            bottom: 20px;
            border-radius: 20px;
        }
    </style>

    <a href="<?= Url::to("/Reservations/reservations/create2") ?>" class="btn btn-floating-right-bottom btn-app bg-purple"><i class="fa fa-plus-square-o"></i></a>
</div>
