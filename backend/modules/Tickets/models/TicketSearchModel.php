<?php

namespace backend\modules\Tickets\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Default model for the `TicketSearchModel` module
 */
class TicketSearchModel extends MadActiveRecord {

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

    public static function getTicket($tsm, $id) {
        $a = $tsm::find()->where(['=', 'ticketId', $id])->one();

        return $a;
    }
}
