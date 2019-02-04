<?php

namespace backend\modules\Products\models;

use Yii;

/**
 * This is the model class for table "products_ga_dossiers".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $ga_dossier_id
 * @property string $name
 * @property string $product_line
 * @property string $departures_start_date
 * @property string $departures_end_date
 * @property string $description
 * @property string $link_overview
 * @property string $link_details
 * @property string $link_pricing
 * @property string $link_details_pdf
 *
 * @property Products $product
 */
class Productsgadossiers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_ga_dossiers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'ga_dossier_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'link_overview', 'link_details', 'link_pricing', 'link_details_pdf'], 'string', 'max' => 300],
            [['product_line'], 'string', 'max' => 30],
            [['departures_start_date', 'departures_end_date'], 'string', 'max' => 10]
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
            'ga_dossier_id' => Yii::t('app', 'Ga Dossier ID'),
            'name' => Yii::t('app', 'Name'),
            'product_line' => Yii::t('app', 'Product Line'),
            'departures_start_date' => Yii::t('app', 'Departures Start Date'),
            'departures_end_date' => Yii::t('app', 'Departures End Date'),
            'description' => Yii::t('app', 'Description'),
            'link_overview' => Yii::t('app', 'Link Overview'),
            'link_details' => Yii::t('app', 'Link Details'),
            'link_pricing' => Yii::t('app', 'Link Pricing'),
            'link_details_pdf' => Yii::t('app', 'Link Details Pdf'),
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
