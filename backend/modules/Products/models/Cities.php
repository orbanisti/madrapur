<?php
namespace backend\modules\Products\models;

use Yii;
use lajax\translatemanager\helpers\Language;
use backend\modules\Products\models\Citiestranslate;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $name
 */
class Cities extends \yii\db\ActiveRecord
{

    public $name_t;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'country'], 'string', 'max' => 255]
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
            'country' => Yii::t('app', 'Ország'),
        ];
    }

    

    /*public function behaviors()

    {

        return [

            'translatebehavior' => [

                'class' => \lajax\translatemanager\behaviors\TranslateBehavior::className(),

                'translateAttributes' => ['name'],

                'category' => static::tableName(),

            ],

        ];

    }*/

    

    public function afterFind()

    {

        parent::afterFind();

        if(Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))

            $this->attributes=$this->translation->attributes;

    }

    

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            

            //Language::saveMessage($this->name, static::tableName());

            

            return true;

        }



        return false;

    }

    

    /**

     * @return string Returning the 'name' attribute on the site's own language.

     */

    /*public function getName($params = [], $language = null) {

        return Language::t(static::tableName(), $this->name, $params, $language);

    }*/

    

    public function getTranslations()

    {

        return $this->hasMany(Citiestranslate::className(), ['city_id' => 'id']);

    }

    

    public function getTranslation()

    {

        return Citiestranslate::findOne(['city_id' => $this->id, 'lang_code'=>Yii::$app->language]);

    }

    

    public static function getCitiestochk()

    {

        return ArrayHelper::map(self::find()->All(), 'id', 'name');

    }

    

    public static function getCitiesbyids($ids)

    {

        return self::find()->where(['id' => $ids,])->all();

    }

}

