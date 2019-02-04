<?php

namespace backend\modules\Products\models;





use Yii;





/**


 * This is the model class for table "products_price_translate".


 *


 * @property integer $id


 * @property integer $product_price_id


 * @property string $name


 * @property string $description


 */


class Productspricetranslate extends \yii\db\ActiveRecord


{


    /**


     * @inheritdoc


     */


    public static function tableName()


    {


        return 'products_price_translate';


    }





    /**


     * @inheritdoc


     */


    public function rules()


    {


        return [


            //[['product_price_id', 'name', 'description'], 'required'],


            [['product_price_id'], 'integer'],


            [['name'], 'string', 'max' => 255],


            [['description'], 'string', 'max' => 1000],


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


            'product_price_id' => Yii::t('app', 'Product Price ID'),


            'name' => Yii::t('app', 'Name'),


            'description' => Yii::t('app', 'Description'),


            'lang_code' => Yii::t('app', 'Nyelv kód'),


        ];


    }


}


