<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Default model for the `Product` module
 */
class ProductAddOn extends MadActiveRecord {


    public static function tableName() {
        return 'modulusProductAddOns';
    }

    public function search($params) {
        $what = ['*'];
        $from = self::tableName();
        $where = "1";

        $rows = self::aSelect(Product::class, $what, $from, $where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public function rules() {
        return [
            [['id'], 'integer', 'max' => 11],
            [['prodId'], 'integer', 'max' => 11],
            [['name'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 255],
        ];
    }
}
