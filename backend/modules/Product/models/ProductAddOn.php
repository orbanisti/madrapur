<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;

/**
 * Default model for the `Product` module
 *
 * @property int $id [int(11)]
 * @property int $addOnId [int(11)]
 * @property int $prodId [int(11)]
 */
class ProductAddOn extends MadActiveRecord {

    public static function tableName() {
        return 'modulusProductAddOnLink';
    }

    public function rules() {
        return [
            [['id', 'prodId', 'addOnId'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', ' '),
            'addOnId' => Yii::t('app', 'Add-on ID'),
            'prodId' => Yii::t('app', 'Product ID'),
        ];
    }

    public function getProduct() {
        return $this->hasOne(Product::class, ['id' => 'prodId']);
    }

    public function getAddOn() {
        return $this->hasOne(AddOn::class, ['id' => 'addOnId']);
    }
}
