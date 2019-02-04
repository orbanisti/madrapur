<?php

namespace backend\modules\Products\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "products_grayline_partners".
 *
 * @property integer $id
 * @property string $name
 * @property integer $channel
 * @property string $description
 * @property string $link
 */
class Graylinepartners extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;

    public static function status($n=false)
    {
        $tt = [
            1 => Yii::t('app', 'aktív'),
            0 => Yii::t('app', 'inaktív'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_grayline_partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'channel'], 'required'],
            [['channel', 'status', 'imported'], 'integer'],
            [['name', 'link'], 'string', 'max' => 300],
            [['description'], 'string', 'max' => 500],
            [['language'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Név'),
            'channel' => Yii::t('app', 'Azonosító'),
            'description' => Yii::t('app', 'Leírás'),
            'link' => Yii::t('app', 'Link'),
            'status' => Yii::t('app', 'Státusz'),
            'language' => Yii::t('app', 'Nyelv'),
            'imported' => Yii::t('app', 'Importálva'),
        ];
    }

    public static function getDropdownlist()
    {
        return ArrayHelper::map(self::find()/*->where(['status'=>1])*/->all(), 'channel', 'name');
    }

    public function afterDelete() {
        parent::afterDelete();

        Products::deleteAll(['source'=>Products::SOURCE_GRAYLINE, 'channel_id'=>$this->channel]);
    }
}
