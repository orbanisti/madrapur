<?php
namespace common\commands;

use backend\modules\Reservations\models\Reservations;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\Tickets\models\TicketBlockDummySearchModel;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use backend\modules\Tickets\models\TicketSearchModel;
use trntv\bus\interfaces\SelfHandlingCommand;
use yii\base\BaseObject;

class AddTicketToReservationCommand extends BaseObject implements SelfHandlingCommand {

    public $sellerId;
    public $timestamp;
    public $bookingId;


    /**
     * @param $command
     *
     * @return mixed
     */
    public function handle($command) {
        $ticketBlock = TicketBlockSearchModel::find()->andFilterWhere(['=', 'assignedTo', $command->sellerId])->one();
        $startId = $ticketBlock->returnStartId();
        $model = TicketBlockDummySearchModel::useTable('modulus_tb_' . $startId)::find()->andFilterWhere(['=', 'sellerId',
            null])->andFilterWhere(['=', 'reservationId', null])->one();
        $sql = TicketBlockDummySearchModel::useTable
        ('modulus_tb_' . $startId)::find()->andFilterWhere(['=', 'sellerId',
            null])->andFilterWhere(['=', 'reservationId', null]);
\Yii::error($sql->sql);
        $model->sellerId = $command->sellerId;
        $model->timestamp = $command->timestamp;
        $model->reservationId = $command->bookingId;

        return $model->save(false);
    }
}