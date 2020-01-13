<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Modorder extends Model {

    public $productId;

    public $priceId;


    /**
     *
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [
                [
                    'productId',
                    'priceId',
                ],
                'required'
            ],
            // We need to sanitize them

            // email has to be a valid email address

        ];
    }

    /**
     *
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'productId' => Yii::t('frontend', 'Product Id'),
            'priceId' => Yii::t('frontend', 'Price Id'),

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email
     *            the target email address
     * @return boolean whether the model passes validation
     */

}
