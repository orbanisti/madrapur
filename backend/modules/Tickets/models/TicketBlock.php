<?php

namespace backend\modules\Tickets\models;

use Yii;

/**
 * Default model for the `TicketBlock` module
 *
 * @property int $id [int(11)]
 * @property string $startId [varchar(8)]
 * @property int $assignedBy [int(11)]
 * @property int $assignedTo [int(11)]
 * @property bool $frozen [tinyint(1)]
 * @property int $timestamp [timestamp]
 */
class TicketBlock extends Tickets {

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'startId' => Yii::t('app', 'Start ticket ID'),
        ];
    }

}
