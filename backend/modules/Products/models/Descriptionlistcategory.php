<?php

namespace backend\modules\Products



namespace app\modules\Products\models;





use Yii;





/**


 * This is the model class for table "description_list_category".


 *


 * @property integer $id


 * @property string $name


 * @property integer $product_id


 *


 * @property DescriptionList[] $descriptionLists


 * @property Products $product


 */


class Descriptionlistcategory extends \yii\db\ActiveRecord


{


    /**


     * @inheritdoc


     */


    public static function tableName()


    {


        return 'description_list_category';


    }





    /**


     * @inheritdoc


     */


    public function rules()


    {


        return [


            [['name', 'product_id'], 'required'],


            [['product_id'], 'integer'],


            [['name'], 'string', 'max' => 255]


        ];


    }





    /**


     * @inheritdoc


     */


    public function attributeLabels()


    {


        return [


            'id' => Yii::t('app', 'ID'),


            'name' => Yii::t('app', 'Name'),


            'product_id' => Yii::t('app', 'Product ID'),


        ];


    }





    /**


     * @return \yii\db\ActiveQuery


     */


    public function getDescriptionLists()


    {


        return $this->hasMany(DescriptionList::className(), ['list_category_id' => 'id']);


    }





    /**


     * @return \yii\db\ActiveQuery


     */


    public function getProduct()


    {


        return $this->hasOne(Products::className(), ['id' => 'product_id']);


    }


}


