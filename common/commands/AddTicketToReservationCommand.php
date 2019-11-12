<?php
namespace common\commands;

use backend\modules\Reservations\models\Reservations;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketSearchModel;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use trntv\bus\interfaces\SelfHandlingCommand;
use Yii;
use yii\base\BaseObject;

class AddTicketToReservationCommand extends BaseObject implements SelfHandlingCommand {

    public $sellerId;
    public $timestamp;
    public $bookingId;
    public $block;


    /**
     * @param $command
     *
     * @return mixed
     */
    public function handle($command) {
        $ticketBlock = $command->block;
        $startId = $ticketBlock->returnStartId();
        $model = TicketSearchModel::useTable('modulus_tb_' . $startId)::find()->andWhere(['sellerId' =>
            null])->andWhere(['reservationId' => null])->andWhere(['status' => 'open'])->one();
        Yii::error($model->attributes);

        if (!$model) {
            sessionSetFlashAlert(
                'warning',
                "Ticket block ($startId) full!"
            );

            return false;
        } else {

            $model->sellerId = $command->sellerId;
            $model->timestamp = $command->timestamp;
            $model->reservationId = $command->bookingId;
            $model->status = 'sold';

            return $model->save(false);
        }
    }
}