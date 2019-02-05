<?php

backend\

namespace app\modules\Users\models\forms;

backend\
backend\
use Yii;

use yii\base\Model;

use app\modules\Users\models\Users;

use app\modules\Users\Module as Usermodule;

/**

 * LoginForm is the model behind the login form.

 */

class ChangepasswordForm extends Model

{

    public $verifyPassword;

    public $oldPassword;

    public $password;



    /**

     * @return array the validation rules.

     */

    public function rules()

    {

        

        return [

            // password rules

            ['password', 'required'],

            ['password', 'string', 'min' => 6],

            ['oldPassword', 'required'],

            ['oldPassword', 'verifyoldpassword'],

            ['verifyPassword', 'required'],

            ['verifyPassword', 'string', 'min' => 6],

            ['verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app', "A két jelszó nem eggyezik.")],

        ];

    }



    public function attributeLabels()

    {

        return [

            'password' => Yii::t('app', 'Jelszó'),

            'verifyPassword' => Yii::t('app', 'Jelszó újra'),

            'oldPassword' => Yii::t('app', 'Régi jelszó'),

        ];

    }

    

    public function verifyOldPassword($attribute, $params)

    {

        if (Users::findOne(Yii::$app->user->id)->password != Usermodule::encrypting($this->$attribute))

            $this->addError($attribute, Yii::t('app', "A régi jelszó helytelen."));

    }

    

    public function changepassword()

    {

        if ($this->validate()) {

            

            $user=Users::findOne(Yii::$app->user->id);

            

            $user->hashcode=Usermodule::encrypting(microtime().$this->password);

            $user->password=Usermodule::encrypting($this->password);

            

            $user->save();

            

            return true;

        } else {

            return false;

        }

    }



}