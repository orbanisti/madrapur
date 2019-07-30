<?php

namespace backend\modules\Tickets\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Default model for the `TicketBlockSearchModel` module
 */
class TicketBlockSearchModel extends TicketBlock {

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (! ($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if (Yii::$app->user->can(Tickets::VIEW_TICKET_BLOCKS))
            $query->andFilterWhere([

            ]);

        return $dataProvider;
    }

    public function returnId() {
        return $this['id'];
    }

    public function returnStartId() {
        return $this['startId'];
    }

    public function returnCurrentId() {
        $tableName = 'modulus_tb_' . $this['startId'];

        if (Yii::$app->db->schema->getTableSchema("users", true) === null) {
            $ticketBlock = self::aSelect(self::class, '*', $tableName, 'sellerId IS NULL', 'ticketId', 'ticketId')->one();
            Yii::error($ticketBlock);

            return $ticketBlock['startId'];
        }

        return "N/A";
    }
}
