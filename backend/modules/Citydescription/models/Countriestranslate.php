<?php

namespace app\modules\Citydescription\models;

use Yii;

/**
 * This is the model class for table "countries_translate".
 *
 * @property integer $id
 * @property string $country_name
 * @property string $capital
 * @property string $content
 * @property string $lang_code
 */
class Countriestranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','extra_info'], 'string'],
            [['country_name'], 'string', 'max' => 200],
            [['capital'], 'string', 'max' => 30],
            [['lang_code'], 'string', 'max' => 5],
            [['country_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_name' => Yii::t('app', 'Név'),
            'capital' => Yii::t('app', 'Főváros'),
            'content' => Yii::t('app', 'Tartalom'),
            'lang_code' => Yii::t('app', 'Nyelv'),
            'country_id' => Yii::t('app', 'Ország'),
            'extra_info' => Yii::t('app', 'További információk'),
        ];
    }
}
