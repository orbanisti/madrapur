<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 7/31/2019
 * Time: 11:02 AM
 */

namespace backend\modules\Tickets\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;

class TicketSearchModel extends MadActiveRecord {

    /**
     * @return array|string[]
     */
    public static function primaryKey() {
        return ['ticketId'];
    }

    public static function userNextTicketId(){
        $ticketBlock = TicketBlockSearchModel::aSelect(TicketBlockSearchModel::class, '*', TicketBlockSearchModel::tableName(), 'assignedTo = ' . Yii::$app->user->id . ' AND isActive IS TRUE')->one();
        $nextTicket=TicketSearchModel::useTable('modulus_tb_' . $ticketBlock->returnStartId())::findOne(['reservationId'
                                                                                                      =>
                                                                                                     null,
                                                                                             'status' => 'open']);

        return $nextTicket->ticketId;
    }

    public static function findTicketBlockOf($ticketId){
        $userTicketBlocks=TicketBlockSearchModel::userTicketBlocks();
        foreach($userTicketBlocks as $ticketBlock){
            if($ticketId-50<$ticketBlock->startId){
                return $ticketBlock;
            }

        }


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
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        $ticketId = Yii::$app->request->get('ticketId');
        if ($ticketId) {
            $query->andFilterWhere([
                'LIKE',
                'ticketId',
                $ticketId
            ]);
        }

        $timestamp = Yii::$app->request->get('timestamp');
        if ($timestamp) {
            $query->andFilterWhere([
                'LIKE',
                'timestamp',
                $timestamp
            ]);
        }

        $reservationId = Yii::$app->request->get('reservationId');
        if ($reservationId) {
            $query->andFilterWhere([
                'LIKE',
                'reservationId',
                $reservationId
            ]);
        }

        $status = Yii::$app->request->get('status');
        if ($status) {
            $query->andFilterWhere([
                'LIKE',
                'status',
                $status
            ]);
        }

        if (!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }


}