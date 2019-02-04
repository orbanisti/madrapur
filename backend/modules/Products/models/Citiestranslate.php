<?php
namespace backend\modules\Products\models;



use Yii;



/**

 * This is the model class for table "cities_translate".

 *

 * @property integer $id

 * @property string $name

 * @property integer $city_id

 * @property string $lang_code

 */

class Citiestranslate extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'cities_translate';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            //[['name', 'city_id', 'lang_code'], 'required'],

            [['city_id'], 'integer'],

            [['name', 'country'], 'string', 'max' => 255],

            [['lang_code'], 'string', 'max' => 5]

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

            'lang_code' => Yii::t('app', 'Nyelv kód'),

        ];

    }

}

