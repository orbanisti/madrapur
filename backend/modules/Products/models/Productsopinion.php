<?php

namespace backend\modules\Products\models;







use Yii;



use backend\modules\Users\models\Users;







/**



 * This is the model class for table "products_opinion".



 *



 * @property integer $id



 * @property integer $product_id



 * @property integer $user_id



 * @property integer $rating



 * @property string $comment



 *



 * @property Users $user



 * @property Products $product



 */



class Productsopinion extends \yii\db\ActiveRecord



{



    /**



     * @inheritdoc



     */



    public static function tableName()



    {



        return 'products_opinion';



    }







    /**



     * @inheritdoc



     */



    public function rules()



    {



        return [



            [['product_id', 'user_id', 'rating', 'comment'], 'required'],



            [['product_id', 'user_id'], 'integer'],



            [['rating'], 'double'],



            [['comment'], 'string', 'max' => 800]



        ];



    }







    /**



     * @inheritdoc



     */



    public function attributeLabels()



    {



        return [



            'id' => Yii::t('app', 'ID'),



            'product_id' => Yii::t('app', 'Termék'),



            'user_id' => Yii::t('app', 'Felhasználó'),



            'rating' => Yii::t('app', 'Értékelés'),



            'comment' => Yii::t('app', 'Vélemény'),



        ];



    }







    /**



     * @return \yii\db\ActiveQuery



     */



    public function getUser()



    {



        return $this->hasOne(Users::className(), ['id' => 'user_id']);



    }







    /**



     * @return \yii\db\ActiveQuery



     */



    public function getProduct()



    {



        return $this->hasOne(Products::className(), ['id' => 'product_id']);



    }



}



