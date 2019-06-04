<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Product` module
 */
class ProductBlockoutTime extends MadActiveRecord{

    public static function tableName()
    {
        return 'modulusProductBlockedTimes';
    }

    public function rules()
    {
        return [

            [['date', 'product_id'], 'required'],

            [['product_id'], 'integer'],

            [['date'], 'string', 'max' => 50],

            //['start_date','validateDates'],

        ];
    }

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'date' => Yii::t('app', 'Time to Block'),

            'product_id' => Yii::t('app', 'ProductId'),

        ];

    }

    public function init() {
        parent::init();



        return true;
    }
    public function initTime(){
        if($this->start_date=='' || is_null($this->start_date) || $this->start_date=='0000-00-00'){
            $this->start_date=date('Y-m-d');
            //\backend\components\extra::e($this);
        }
        return $this;

    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function afterFind() {
        parent::afterFind();

        if($this->start_date=='' || is_null($this->start_date) || $this->start_date=='0000-00-00'){
            $this->start_date=date('Y-m-d');
        }

        if($this->end_date=='' || is_null($this->end_date) || $this->end_date=='0000-00-00'){
            $this->end_date=date('Y-m-d');
        }

        return true;
    }

}
