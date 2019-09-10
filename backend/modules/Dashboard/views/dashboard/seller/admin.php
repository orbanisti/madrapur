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
        'text' => ' ',
        'icon' => 'fa fa-ticket',
        'text' => 'Next ticked ID',
        'footer' => 'View ticket block',
        'link' => Url::to("/Tickets/tickets/view-block?id=$startTicketId")
    ])::end();

    ?>

    <a href="<?= Url::to("/Dashboard/dashboard/admin?skip-ticket=$nextTicketId") ?>" class="btn btn-block btn-primary btn-lg">Skip current ticket</a>

    <a href="<?= Url::to("/Dashboard/dashboard/admin?change-ticket-block=$startTicketId") ?>" class="btn btn-block btn-primary btn-lg">Change Ticket Block</a>
</div>