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

class RecoverypasswordForm extends Model

{

    public $verifyPassword;

    public $password;

    public $userid;



    /**

     * @return array the validation rules.

     */

    public function rules()

    {

        

        return [

            ['userid', 'required'],

            [['userid'], 'integer'],

            ['password', 'required'],

            ['password', 'string', 'min' => 6],

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

            'userid' => Yii::t('app', 'Felhasználó'),

        ];

    }

    

    public function recoverypassword()

    {

        if ($this->validate()) {

            

            $user=Users::findOne($this->userid);

            

            $user->hashcode=Usermodule::encrypting(microtime().$this->password);

            $user->password=Usermodule::encrypting($this->password);

            

            $user->save();

            

            return true;

        } else {

            return false;

        }

    }



}