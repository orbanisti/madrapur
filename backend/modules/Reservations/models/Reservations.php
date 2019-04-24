<?php

namespace backend\modules\Reservations\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;

class Reservations extends MadActiveRecord
{

    public static function tableName()
    {
        return 'modulusBookings'; //TODO: dynamic table name
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['bookingId'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['data'], 'string', 'max' => 1000],
            [['productId'], 'string', 'max' => 32],
            [['invoiceDate'], 'date', 'format' => 'yyyy-MM-dd'],
            [['bookingDate'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bookingId' => Yii::t('app', 'BookingID'),
            'source' => Yii::t('app', 'Source'),
            'data' => Yii::t('app', 'JSON adat'),
            'productId' => Yii::t('app', 'Product Id'),
            'invoiceDate' => Yii::t('app', 'Invoice  date'),
            'bookingDate' => Yii::t('app', 'Booking date'),
        ];
    }
    public static function primaryKey()
    {
        return ["id"];
    }

    public function afterFind()
    {
        parent::afterFind();


    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'bookingId', 'bookingDate');
    }


}