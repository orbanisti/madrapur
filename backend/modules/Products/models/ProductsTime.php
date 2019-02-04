<?php
namespace backend\modules\Products\models;

use Yii;
use backend\modules\Products\models\Products;

class ProductsTime extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'products_time';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['product_id', 'all_time'], 'integer'],
            [['start_date', 'end_date'], 'date','format' => 'yyyy-M-d'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Termék'),
            'name' => Yii::t('app', 'Név'),
            'all_time' => Yii::t('app', 'Minden időszakban'),
            'start_date' => Yii::t('app', 'Kezdő dátum'),
            'end_date' => Yii::t('app', 'Utolsó dátum'),
        ];
    }

    public function init() {
        parent::init();

        if($this->start_date=='' || is_null($this->start_date) || $this->start_date=='0000-00-00'){
            $this->start_date=date('Y-m-d');
            //\backend\components\extra::e($this);
        }

        return true;
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
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


