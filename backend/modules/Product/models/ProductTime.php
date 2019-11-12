<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;

/**
 * Default model for the `Product` module
 */
class ProductTime extends MadActiveRecord {

    public static function tableName() {
        return 'modulusProductTimes';
    }

    public function rules() {
        return [

            [['name'], 'required'],
            [['product_id', 'id'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'yyyy-m-d'],
            [['name'], 'string', 'max' => 5000]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Termék'),
            'name' => Yii::t('app', 'Név'),
            'start_date' => Yii::t('app', 'Kezdő dátum'),
            'end_date' => Yii::t('app', 'Utolsó dátum'),
        ];
    }

    public function init() {
        parent::init();

        return true;
    }

    public function initTime() {
        if ($this->start_date == '' || is_null($this->start_date) || $this->start_date == '0000-00-00') {
            $this->start_date = date('Y-m-d');
            //\backend\components\extra::e($this);
        }
        return $this;
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function afterFind() {
        parent::afterFind();

        if ($this->start_date == '' || is_null($this->start_date) || $this->start_date == '0000-00-00') {
            $this->start_date = date('Y-m-d');
        }

        if ($this->end_date == '' || is_null($this->end_date) || $this->end_date == '0000-00-00') {
            $this->end_date = date('Y-m-d');
        }

        return true;
    }

}
