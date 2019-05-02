<?php

namespace backend\modules\Product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Products\models\Products;
use backend\modules\Products\models\Productscities;
use backend\modules\Products\models\Productscountires;
use yii\helpers\ArrayHelper;
use backend\modules\Products\models\Graylinepartners;

class ProductAdminSearchModel extends Product
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['currency'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 255],
            [['thumbnail'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 255],
            [['start_date'], 'string', 'max' => 255],
            [['end_date'], 'string', 'max' => 255],
            [['capacity'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 255]
        ];
    }

    public function search($params)
    {
      #  $invoiceDate = '2016-02-05';
       # $bookingDate = '2020-08-20';

        $what = ['*'];
        $from = self::tableName();
        $where = self::andWhereFilter([
            ['id', '!=', '0'],
        ]);


        $rows = self::aSelect(ProductAdminSearchModel::class, $what, $from,$where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public function returnProductId() {
        return $this['id'];
    }

    public function attributes() {
        $attributes = parent::attributes();
        return array_merge($attributes, [
            'fname'
        ]);
    }
}

