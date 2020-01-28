<?php

namespace backend\modules\Autoimport\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;

/**
 * Default model for the `Autoimport` module
 */
class Autoimport extends MadActiveRecord {

    public static function tableName()
    {
        return 'modulusAutoimports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siteUrl', 'apiUrl', 'type'], 'string'],
            [['active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'siteUrl' => 'Site Url',
            'apiUrl' => 'Api Url',
            'type' => 'Type',
            'active' => 'Active',
        ];
    }
}
