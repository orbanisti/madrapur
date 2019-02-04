<?php


namespace backend\modules\Products


namespace app\modules\Products\models;



use Yii;

use app\modules\Products\models\Products;

use app\modules\Citydescription\models\Citydescription;





/**



 * This is the model class for table "products_cities".



 *



 * @property integer $id

 * @property integer $product_id

 * @property integer $city_id

 *



 * @property Products $product

 * @property Cities $city

 */



class Productscities extends \yii\db\ActiveRecord

{



    /**



     * @inheritdoc



     */



    public static function tableName()



    {



        return 'products_cities';



    }







    /**



     * @inheritdoc



     */



    public function rules()



    {



        return [

            [['product_id', 'city_id'], 'required'],

            [['product_id', 'city_id'], 'integer']

        ];



    }







    /**



     * @inheritdoc



     */



    public function attributeLabels()



    {



        return [



            'id' => Yii::t('app', 'ID'),

            'product_id' => Yii::t('app', 'Product ID'),

            'city_id' => Yii::t('app', 'City ID'),

        ];



    }







    /**



     * @return \yii\db\ActiveQuery



     */



    public function getProduct()



    {



        return $this->hasOne(Products::className(), ['id' => 'product_id']);

    }







    /**



     * @return \yii\db\ActiveQuery



     */



    public function getCity()

    {



        return $this->hasOne(Citydescription::className(), ['id' => 'city_id']);

    }



}



