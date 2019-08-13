<?php

namespace backend\modules\Tickets\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `TicketBlock` module
 */
class TicketBlock extends Tickets {

    private const TABLE_PREFIX = 'modulus_tb_';

    public function attributeLabels() {
        return [
            'startId' => Yii::t('app', 'Start ticket ID'),
        ];
    }

}
