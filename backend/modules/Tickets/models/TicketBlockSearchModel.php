<?php

namespace backend\modules\Tickets\models;

use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Default model for the `TicketBlockSearchModel` module
 *
 * @property int $id [int(11)]
 * @property int $assignedBy [int(11)]
 * @property int $assignedTo [int(11)]
 * @property bool $frozen [tinyint(1)]
 * @property int $timestamp [timestamp]
 */
class TicketBlockSearchModel extends TicketBlock {

    protected static $startId;

    /**
     * @param $id
     *
     * @return string
     */
    public static function getStartId($id) {
        $ticketBlock = static::find()->where(['=', 'id', $id])->one();

        return $ticketBlock->returnStartId();
    }

    /**
     * @return string
     */
    public function returnStartId() {
        return $this['startId'];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();

        if (!Yii::$app->user->can(Tickets::VIEW_TICKET_BLOCKS)) {
            $query->andFilterWhere([
                '=',
                'assignedTo',
                Yii::$app->user->id
            ]);
        } else {
            $assignedTo = Yii::$app->request->getQueryParam('assignedTo', null);

            if ($assignedTo) {
                if (!($user = User::findByUsername($assignedTo))) {
                    sessionSetFlashAlert('warning', 'You can only search with full username specified!');
                } else {
                    $query->andFilterWhere([
                        'LIKE',
                        'assignedTo',
                        $user->id
                    ]);
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

    /**
     * @return string
     */
    public function returnId() {
        return $this['id'];
    }

    /**
     * @return string
     */
    public function returnCurrentId() {
        $tableName = 'modulus_tb_' . $this['startId'];

        if (!table_exists($tableName)) {
            return "N/A";
        }

        $ticketBlock = self::useTable($tableName)::aSelect(
            TicketBlockDummySearchModel::class,
            '*', $tableName, 'sellerId IS NULL',
            'ticketId', 'ticketId'
        )->one();

        return $ticketBlock->ticketId;
    }
}
