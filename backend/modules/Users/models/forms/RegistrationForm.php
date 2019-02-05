<?php

backend\

namespace app\modules\Users\models\forms;

backend\
backend\
use backend\

//use yii\base\Model;

use app\modules\Users\models\Users;

use app\modules\Users\models\Profile;

use app\modules\Users\Module as Usermodule;

/**

 * LoginForm is the model behind the login form.

 */

class RegistrationForm extends Users

{

    public $verifyPassword;

    public $tax_code;

    public $bank_acc_number;

    public $reg_code;

    public $zipcode;

    public $address;

    public $city;

    public $country;

    public $company_name;



    /**

     * @return array the validation rules.

     */

    public function rules()

    {

        $user = Yii::$app->getModule('users')->modelMap['Users'];

        //Yii::$app->extra->e($user);

        

        return [

            // username rules

            ['username', 'string', 'min' => 3, 'max' => 255],

            ['username', 'filter', 'filter' => 'trim'],

            ['username', 'match', 'pattern' => $user::$usernameRegexp],

            ['username', 'required'],

            ['username', 'unique', 'message' => Yii::t('app', 'Ez a felhasználónév foglalt')],

            // email rules

            ['email', 'filter', 'filter' => 'trim'],

            ['email', 'required'],

            ['email', 'email'],

            ['email', 'unique', 'message' => Yii::t('app', 'Ez az email cím foglalt')],

            // password rules

            ['password', 'required'],

            ['password', 'string', 'min' => 6],

            ['verifyPassword', 'required'],

            ['verifyPassword', 'string', 'min' => 6],

            ['verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app', "A két jelszó nem eggyezik.")],

            // user type

            //['type', 'required'],

            [['zipcode'], 'string', 'max' => 32],

            [['address'], 'string', 'max' => 255],

            [['company_name'], 'string', 'max' => 500],

            [['country', 'city'], 'string', 'max' => 128],

            [['tax_code', 'bank_acc_number', 'reg_code'], 'string', 'max' => 200],

            [['company_name', 'zipcode', 'address', 'city', 'country', 'tax_code', 'bank_acc_number', 'reg_code'], 'required', 'on' => 'partnerregistration'],

        ];

    }



    public function attributeLabels()

    {

        return [

            'email'    => Yii::t('app', 'Email cím'),

            'username' => Yii::t('app', 'Felhasználónév'),

            'password' => Yii::t('app', 'Jelszó'),

            'verifyPassword' => Yii::t('app', 'Jelszó újra'),

            'type' => Yii::t('app', 'Típus'),

            'tax_code' => Yii::t('app', 'Adószám'),

            'tax_code' => Yii::t('app', 'Adószám'),

            'company_name' => Yii::t('app', 'Cégnév'),

            'reg_code' => Yii::t('app', 'Regisztrációs szám'),

        ];

    }

    

    public function registration($type)

    {

        if ($this->validate()) {

            

            $this->hashcode=Usermodule::encrypting(microtime().$this->password);

            $this->password=Usermodule::encrypting($this->password);

            $this->verifyPassword=Usermodule::encrypting($this->verifyPassword);

            

            if(Yii::$app->request->cookies->has(Yii::$app->params['langCookiename'])) {

                Yii::$app->language = Yii::$app->request->cookies->getValue(Yii::$app->params['langCookiename']);

            }

            //$this->lang_code=Yii::$app->params['defaultLangcode'];

            $this->lang_code=Yii::$app->language;

            

            $this->status=Usermodule::STATUS_NOACTIVE;

            $this->type=$type;

            

            $this->save();



                $profile=new Profile;

                $profile->userid=$this->id;

                if($type==Usermodule::TYPE_PARTNER) {

                    $profile->country=$this->country;

                    $profile->zipcode=$this->zipcode;

                    $profile->city=$this->city;

                    $profile->address=$this->address;

                    $profile->tax_code=$this->tax_code;

                    $profile->bank_acc_number=$this->bank_acc_number;

                    $profile->reg_code=$this->reg_code;

                    $profile->company_name=$this->company_name;

                }

                $profile->save(false);

            

            return true;

        } else {

            return false;

        }

    }



}