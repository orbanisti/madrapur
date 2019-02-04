<?php

namespace backend\modules\Products\models;

use Yii;

/**
 * This is the model class for table "products_ga_departures".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $ga_departure_id
 * @property string $date_created
 * @property string $date_last_modified
 * @property string $name
 * @property string $start_date
 * @property string $finish_date
 * @property string $product_line
 * @property string $sku
 * @property string $flags
 * @property string $start_address_street
 * @property string $start_address_city
 * @property string $start_address_country
 * @property string $start_address_zip
 * @property double $start_address_latitude
 * @property double $start_address_longitude
 * @property string $finish_address_street
 * @property string $finish_address_city
 * @property string $finish_address_country
 * @property string $finish_address_zip
 * @property double $finish_address_latitude
 * @property double $finish_address_longitude
 * @property string $latest_arrival_time
 * @property string $earliest_departure_time
 * @property string $nearest_start_airport
 * @property string $nearest_finish_airport
 * @property string $availability_status
 * @property integer $availability_total
 * @property integer $availability_male
 * @property integer $availability_female
 * @property double $lowest_price
 *
 * @property Products $product
 */
class Productsgadepartures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_ga_departures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'ga_departure_id', 'availability_total', 'availability_male', 'availability_female'], 'integer'],
            [['start_address_latitude', 'start_address_longitude', 'finish_address_latitude', 'finish_address_longitude', 'lowest_price'], 'number'],
            [['lowest_price'], 'required'],
            [['date_created', 'date_last_modified', 'sku', 'start_address_zip', 'latest_arrival_time', 'earliest_departure_time', 'nearest_finish_airport', 'availability_status'], 'string', 'max' => 30],
            [['name', 'flags'], 'string', 'max' => 300],
            [['status'], 'string', 'max' => 100],
            [['start_date', 'finish_date', 'product_line', 'nearest_start_airport'], 'string', 'max' => 10],
            [['start_address_street', 'start_address_city', 'start_address_country', 'finish_address_street', 'finish_address_city', 'finish_address_country', 'finish_address_zip'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'ga_departure_id' => Yii::t('app', 'Ga Departure ID'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_last_modified' => Yii::t('app', 'Date Last Modified'),
            'name' => Yii::t('app', 'Name'),
            'start_date' => Yii::t('app', 'Start Date'),
            'finish_date' => Yii::t('app', 'Finish Date'),
            'product_line' => Yii::t('app', 'Product Line'),
            'sku' => Yii::t('app', 'Sku'),
            'flags' => Yii::t('app', 'Flags'),
            'start_address_street' => Yii::t('app', 'Start Address Street'),
            'start_address_city' => Yii::t('app', 'Start Address City'),
            'start_address_country' => Yii::t('app', 'Start Address Country'),
            'start_address_zip' => Yii::t('app', 'Start Address Zip'),
            'start_address_latitude' => Yii::t('app', 'Start Address Latitude'),
            'start_address_longitude' => Yii::t('app', 'Start Address Longitude'),
            'finish_address_street' => Yii::t('app', 'Finish Address Street'),
            'finish_address_city' => Yii::t('app', 'Finish Address City'),
            'finish_address_country' => Yii::t('app', 'Finish Address Country'),
            'finish_address_zip' => Yii::t('app', 'Finish Address Zip'),
            'finish_address_latitude' => Yii::t('app', 'Finish Address Latitude'),
            'finish_address_longitude' => Yii::t('app', 'Finish Address Longitude'),
            'latest_arrival_time' => Yii::t('app', 'Latest Arrival Time'),
            'earliest_departure_time' => Yii::t('app', 'Earliest Departure Time'),
            'nearest_start_airport' => Yii::t('app', 'Nearest Start Airport'),
            'nearest_finish_airport' => Yii::t('app', 'Nearest Finish Airport'),
            'availability_status' => Yii::t('app', 'Availability Status'),
            'availability_total' => Yii::t('app', 'Availability Total'),
            'availability_male' => Yii::t('app', 'Availability Male'),
            'availability_female' => Yii::t('app', 'Availability Female'),
            'lowest_price' => Yii::t('app', 'Lowest Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
