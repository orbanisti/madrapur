<?php

namespace backend\modules\Reservations\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Products\models\Products;
use backend\modules\Products\models\Productscities;
use backend\modules\Products\models\Productscountires;
use yii\helpers\ArrayHelper;
use backend\modules\Products\models\Graylinepartners;

class ReservationsAdminSearchModel extends Reservations
{

    public function rules()
    {
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


    public function search($params)
{
    $invoiceDate = '2016-02-05';
    $bookingDate = '2020-08-20';

    $what = ['*'];
    $from = self::tableName();
    $where = self::andWhereFilter([
        ['invoiceDate', '>=', $invoiceDate],
        ['bookingDate', '<=', $bookingDate],
        # ['source', 'LIKE', 'utca']
    ]);

    $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where);
    $rows= $query = ReservationsAdminSearchModel::find()->indexBy('id');;
    $dataProvider = new ActiveDataProvider([
        'query' => $rows,
        'pagination' => [
            'pageSize' => 15,
        ],
    ]);

    $this->load($params);

    return $dataProvider;
}


    public function searchDay($params,$sources,$prodId)
    {
        $invoiceDate = '2016-02-05';
        $bookingDate = '2020-08-20';
        $selectedDate=\Yii::$app->request->get("date");

        $what = ['*'];
        $from = self::tableName();

        $wheres=[];
        $where2=[];
        $wheres[]=['bookingDate', '=', $selectedDate];
        $wheres[]=['productId', 'IN', $sources];

        $where = self::andWhereFilter($wheres);







        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where,$sources,$prodId);


        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);




        $this->load($params);

        return $dataProvider;
    }

    public function searchChart($params)
    {
        $invoiceDate = '2016-02-05';
        $bookingDate = '2020-08-20';

        $what = ['*'];
        $from = self::tableName();
        $where = self::andWhereFilter([
            ['invoiceDate', '>=', $invoiceDate],
            ['bookingDate', '<=', $bookingDate]
            # ['source', 'LIKE', 'utca']
        ]);



        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public function returnBookingId() {
        return $this['bookingId'];
    }


}

