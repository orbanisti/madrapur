<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 7/31/2019
 * Time: 11:02 AM
 */

namespace backend\modules\Tickets\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use yii\data\ActiveDataProvider;

class TicketBlockDummySearchModel extends MadActiveRecord {

    /**
     * @return array|string[]
     */
    public static function primaryKey() {
        return ['ticketId'];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

}