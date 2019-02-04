<?php

namespace backend\modules\Products\models;



use Yii;



/**

 * This is the model class for table "services_translate".

 *

 * @property integer $id

 * @property string $name

 * @property integer $service_id

 * @property string $lang_code

 */

class Servicestranslate extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'services_translate';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            //[['name', 'service_id', 'lang_code'], 'required'],

            [['service_id'], 'integer'],

            [['name'], 'string', 'max' => 255],

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

            'service_id' => Yii::t('app', 'Szolgáltatás'),

            'lang_code' => Yii::t('app', 'Nyelv kód'),

        ];

    }

}

