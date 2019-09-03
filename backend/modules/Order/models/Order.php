<?php

namespace backend\modules\Order\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;

/**
 * Default model for the `Order` module
 */
class Order extends MadActiveRecord {

    public static function getOrderById($id) {
        $order = Order::aSelect(Order::class, '*', Order::tableName(), 'id = ' . $id);

        return $order->one();
    }

    public static function tableName() {
        return 'modulusOrders';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['transactionId'], 'string', 'max' => 255],
            [['reservationIds'], 'string', 'max' => 255],
            [['data'], 'string', 'max' => 50000],
            [['transactionDate'], 'string', 'max' => 255],
        ];
    }
}
