<?php

namespace backend\modules\Products

namespace app\modules\Products\models;



use Yii;



/**

 * This is the model class for table "products_video".

 *

 * @property integer $id

 * @property string $name

 * @property string $video_link

 * @property integer $video_source

 * @property string $image

 * @property integer $product_id

 *

 * @property Products $product

 */

class Productsvideo extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'products_video';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['name', 'video_link', 'video_source', 'image', 'product_id'], 'required'],

            [['video_source', 'product_id'], 'integer'],

            [['name', 'image'], 'string', 'max' => 255],

            [['video_link'], 'string', 'max' => 500]

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

            'video_link' => Yii::t('app', 'Video Link'),

            'video_source' => Yii::t('app', 'Video Source'),

            'image' => Yii::t('app', 'Image'),

            'product_id' => Yii::t('app', 'Product ID'),

        ];

    }



    /**

     * @return \yii\db\ActiveQuery

     */

    public function getProduct()

    {

        return $this->hasOne(Products::className(), ['id' => 'product_id']);

    }

}

