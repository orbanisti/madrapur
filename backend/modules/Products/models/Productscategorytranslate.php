<?php

namespace backend\modules\Products\models;



use Yii;



/**

 * This is the model class for table "products_category_translate".

 *

 * @property integer $id

 * @property string $name

 * @property string $intro

 * @property string $description

 * @property integer $category_id

 */

class Productscategorytranslate extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'products_category_translate';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            //[['name', 'intro', 'description', 'category_id'], 'required'],

            [['description'], 'string'],

            [['category_id'], 'integer'],

            [['name'], 'string', 'max' => 255],

            [['intro'], 'string', 'max' => 500],

            [['lang_code'], 'string', 'max' => 5],

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

            'intro' => Yii::t('app', 'Rövid leírás'),

            'description' => Yii::t('app', 'Leírás'),

            'category_id' => Yii::t('app', 'Kategória'),

            'lang_code' => Yii::t('app', 'Nyelv kód'),

        ];

    }

}

