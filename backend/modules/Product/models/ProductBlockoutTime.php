<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Default model for the `Product` module
 */
class ProductBlockoutTime extends MadActiveRecord {

    public function rules() {
        return [

            [['date', 'product_id'], 'required'],

            [['product_id'], 'integer'],

            [['date'], 'string', 'max' => 50],

            //['start_date','validateDates'],

        ];
    }

    public function attributeLabels() {

        return [

            'id' => Yii::t('app', 'ID'),

            'date' => Yii::t('app', 'Time to Block'),

            'product_id' => Yii::t('app', 'ProductId'),

        ];
    }

    public function search($params, $productId) {
        #  $invoiceDate = '2016-02-05';
        # $bookingDate = '2020-08-20';

        $what = ['*'];
        $from = self::tableName();
        $where = self::andWhereFilter([
            ['product_id', '=', $productId],
        ]);

        $rows = self::aSelect(ProductBlockoutTime::class, $what, $from, $where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public static function tableName() {
        return 'modulusProductBlockedTimes';
    }

    public function init() {
        parent::init();

        return true;
    }

    public function getProduct() {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}
