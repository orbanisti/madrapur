<?php

namespace backend\modules\Product\models;

use Yii;

/**
 * This is the model class for table "modulusaddonblockouts".
 *
 * @property int $id
 * @property string $productId
 * @property string $addonId
 * @property string $dates
 * @property string $startDate
 * @property string $endDate
 */
class ProductAddonBlockout extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modulusaddonblockouts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productId', 'addonId'], 'required'],
            [['dates'], 'string'],
            [['startDate', 'endDate'], 'safe'],
            [['productId', 'addonId'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'productId' => 'Product ID',
            'addonId' => 'Addon ID',
            'dates' => 'Dates',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
        ];
    }
}
