<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Product` module
 */
class ProductBlockout extends MadActiveRecord{

    public static function tableName()
    {
        return 'modulusProductBlockouts';
    }

    public function rules()
    {
        return [

            [['dates', 'product_id'], 'required'],

            [['product_id'], 'integer'],

            [['start_date','end_date'], 'date', 'format' => 'php:Y-m-d'],

            [['dates'], 'string', 'max' => 8000],

            //['start_date','validateDates'],

        ];
    }

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'start_date' => Yii::t('app', 'Kezdő dátum'),

            'end_date' => Yii::t('app', 'Befejező dátum'),

            'dates' => Yii::t('app', 'Days to Block'),

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
