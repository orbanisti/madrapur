<?php

namespace backend\modules\Tickets\models;

use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Default model for the `TicketBlockSearchModel` module
 */
class TicketBlockSearchModel extends TicketBlock {

    protected static $startId;

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();

        $query->andFilterWhere([
            '!=',
            'startId',
            'V0000000'
        ]);

        if (!Yii::$app->user->can(Tickets::VIEW_TICKET_BLOCKS)) {
            $query->andFilterWhere([
                '=',
                'assignedTo',
                Yii::$app->user->id
            ]);
        } else {
            $assignedTo = Yii::$app->request->getQueryParam('assignedTo', null);
            if ($assignedTo) {
                if ($user = User::findByUsername($assignedTo)) {
                    $query->andFilterWhere([
                        'LIKE',
                        'assignedTo',
                        $user->id
                    ]);
                } else {
                    //TODO: add search for full username warning
                }
            }
        }

        $startId = Yii::$app->request->getQueryParam('startId', null);
        if ($startId) {
            $query->andFilterWhere([
                'LIKE',
                'startId',
                $startId
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

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

        if (Yii::$app->db->schema->getTableSchema($tableName, true) !== null) {
            $ticketBlock = TicketBlockDummySearchModel::useTable($tableName)::aSelect(TicketBlockDummySearchModel::class, '*',
                $tableName, 'sellerId IS NULL', 'ticketId', 'ticketId')
                ->one();

            return $ticketBlock->ticketId;
        }

        return "N/A";
    }

    public static function getStartId($id) {
        $a = static::find()->where(['=', 'id', $id])->one();
Yii::error($id);
        return $a->returnStartId();
    }
}
