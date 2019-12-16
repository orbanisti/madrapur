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

        if (Yii::$app->user->can('streetSeller')) {
            $query->andFilterWhere([
                '=',
                'assignedTo',
                Yii::$app->user->id
            ]);
        } else {
            $assignedTo = Yii::$app->request->getQueryParam('assignedTo', null);

            if (!$assignedTo && isset($params['assignedTo'])) {
                $assignedTo = $params['assignedTo'];
            }

            if ($assignedTo) {
                if (!($user = User::findByUsername($assignedTo))) {
                    sessionSetFlashAlert('warning', 'You can only search with full username specified!');
                } else {
                    $query->andFilterWhere([
                        '=',
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
        return is_string($ticket = $this->returnCurrentTicket()) ? $ticket : (isset($ticket->ticketId)?
            $ticket->ticketId : 'Ticketbook full');
    }

    public function returnCurrentTicket() {
        $tableName = 'modulus_tb_' . $this['startId'];

        if (!table_exists($tableName)) {
            return $this['startId'];
        }

        $ticket = self::useTable($tableName)::aSelect(
            TicketSearchModel::class,
            '*', $tableName, 'sellerId IS NULL AND status = \'open\'',
            'ticketId', 'ticketId'
        )->one();

        return $ticket;
    }

    public function skipCurrentTicket() {
        $ticket = $this->returnCurrentTicket();
        $ticket->sellerId = Yii::$app->user->id;
        $ticket->status = 'skipped';
        $ticket->timestamp = date('Y-m-d H:i:s',time());

        return $ticket->save(false);
    }
}
