<?php
namespace backend\modules\Products\models;



use Yii;

use backend\modules\Products\models\Products;

use backend\modules\Citydescription\models\Countries;



/**



 * This is the model class for table "products_countires".



 *



 * @property integer $id

 * @property integer $product_id

 * @property integer $country_id

 *



 * @property Products $product

 * @property Countries $country

 */



class Productscountires extends \yii\db\ActiveRecord

{



    /**



     * @inheritdoc



     */



    public static function tableName()



    {



        return 'products_countires';



    }







    /**



     * @inheritdoc



     */



    public function rules()



    {



        return [

            [['product_id', 'country_id'], 'required'],

            [['product_id', 'country_id'], 'integer']

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

            'country_id' => Yii::t('app', 'Country ID'),

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



    public function getCountry()



    {



        return $this->hasOne(Countries::className(), ['id' => 'country_id']);

    }



}



