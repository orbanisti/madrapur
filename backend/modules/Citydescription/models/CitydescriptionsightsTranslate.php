<?php

namespace app\modules\Citydescription\models;

use Yii;

class CitydescriptionsightsTranslate extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'citydescription_sights_translate';
    }

    public function rules()
    {
        return [
            [['citydescription_sights_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 1500],
            [['lang_code'], 'string', 'max' => 5]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'citydescription_sights_id' => Yii::t('app', 'Látnivaló'),
            'name' => Yii::t('app', 'Név'),
            'description' => Yii::t('app', 'Leírás'),
            'lang_code' => Yii::t('app', 'Nyelv'),
        ];
    }
}
