<?php

namespace backend\modules\Payment\models;

use backend\modules\Products\models\Graylinepartners;
use backend\modules\Products\models\Products;
use backend\modules\Products\models\Productscities;
use backend\modules\Products\models\Productscountires;
use yii\data\ActiveDataProvider;

class PaymentSearchModel extends Payment {

    public function rules() {
        return [
            [['bookingId'], 'integer'],
            [['source'], 'string', 'max' => 255],
            /*   [['fname'], 'string', 'max' => 255],
               [['lname'], 'string', 'max' => 255],*/
            [['data'], 'string', 'max' => 1000],
            [['invoiceDate'], 'date', 'format' => 'yyyy-MM-dd'],
            [['bookingDate'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function search($params) {
        $rows = $query = PaymentSearchModel::find()->indexBy('id');;
        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public function returnTransactionId() {
        return $this['transactionId'];
    }

    public function returnId() {
        return $this['id'];
    }

}

