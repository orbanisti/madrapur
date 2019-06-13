<?php

namespace backend\modules\Reservations\models;

use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductSource;
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

    $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where, ['invoiceMonth' => SORT_ASC], ['invoiceMonth']);
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


    public function searchMyreservations($params)
    {

        $what = ['*'];
        $from = self::tableName();
        $currentUserId=\Yii::$app->user->getId();

        $where = self::andWhereFilter([
            # ['invoiceDate', '>=', $invoiceDate],
            # ['bookingDate', '<=', $bookingDate],
            # ['source', '=', 'Street'],
            ['sellerId', '=',strval($currentUserId) ],
        ]);

        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where);



        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }



    public function searchAllreservations($params)
    {

        $what = ['*'];
        $from = self::tableName();
        $currentUserId=\Yii::$app->user->getId();

        $searchParams = isset($params['ReservationsAdminSearchModel']) ? $params['ReservationsAdminSearchModel'] : [] ;
        $filters = [];

        foreach ($searchParams as $paramName => $paramValue) {
            if ($paramValue)
                $filters[] = [$paramName, 'LIKE', $paramValue];
        }

        $where = self::andWhereFilter($filters);

        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where, ['invoiceMonth' => SORT_ASC, 'source' => SORT_ASC, 'sellerName' => SORT_ASC, 'bookingId' => SORT_ASC]);



        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }




    public function searchDay($params,$selectedDate,$sources,$prodId)
    {


        $what = ['*'];
        $from = self::tableName();
        $wheres=[];
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
    public function countTakenChairsOnDay($params,$selectedDate,$sources,$prodId)
    {

        $what = ['*'];
        $from = self::tableName();
        $wheres=[];
        $wheres[]=['bookingDate', '=', $selectedDate];
        $wheres[]=['productId', 'IN', $sources];
        $where = self::andWhereFilter($wheres);
        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where,$sources,$prodId);
        $bookigsFromThatDay=$rows->all();
        $counter=0;
        foreach ($bookigsFromThatDay as $reservation){
            if(isset($reservation->bookedChairsCount)){
                $counter=$counter+$reservation->bookedChairsCount;

            }
        }
        return $counter;
    }
    public function availableChairsOnDay($params,$selectedDate,$sources,$prodId)
    {

        $what = ['*'];
        $from = self::tableName();
        $wheres=[];
        $wheres[]=['bookingDate', '=', $selectedDate];
        $wheres[]=['productId', 'IN', $sources];
        $where = self::andWhereFilter($wheres);
        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where,$sources,$prodId);
        $bookigsFromThatDay=$rows->all();
        $counter=0;
        foreach ($bookigsFromThatDay as $reservation){
            if(isset($reservation->bookedChairsCount)){
                $counter=$counter+$reservation->bookedChairsCount;

            }
        }
        $currentProduct=Product::getProdById($prodId);
        $placesleft=$currentProduct->capacity-$counter;
        if($placesleft%2!=0){
            $placesleft-=1;
        }
        return $placesleft;
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

    public function searchChartForStats($startDate = null, $endDate = null, $source = null) {
        $what = ['*'];
        $from = self::tableName();
        $where = self::andWhereFilter([
            ['invoiceDate', '>=', $startDate],
            ['invoiceDate', '<=', $endDate],
            # ['source', 'LIKE', 'utca']
        ]);



        $rows = self::aSelect(ReservationsAdminSearchModel::class, $what, $from, $where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
        ]);

        return $dataProvider;
    }

    public function returnBookingId() {
        return $this['bookingId'];
    }

    public function returnId() {
        return $this['id'];
    }


}

