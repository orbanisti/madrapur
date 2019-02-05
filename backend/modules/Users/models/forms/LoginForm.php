<?php



namespace backend\modules\Users\models\forms;





use Yii;


use yii\base\Model;


use backend\modules\Users\models\Users;


use backend\modules\Users\Module as Usermodule;





/**


 * LoginForm is the model behind the login form.


 */


class LoginForm extends Model


{


    public $username;


    public $password;


    public $rememberMe = false;





    private $_user = false;





    /**


     * @return array the validation rules.


     */


    public function rules()


    {


        return [


            // username and password are both required


            [['username', 'password'], 'required'],


            // rememberMe must be a boolean value


            ['rememberMe', 'boolean'],


            // password is validated by validatePassword()


            ['password', 'validatePassword'],


        ];


    }


    


    public function attributeLabels()


    {


        return [


            'email' => Yii::t('app', 'Email'),


            'username' => Yii::t('app', 'Felhasználónév'),


            'password' => Yii::t('app', 'Jelszó'),


            'rememberMe' => Yii::t('app', 'Maradjak bejelentkezve'),


        ];


    }





    /**


     * Validates the password.


     * This method serves as the inline validation for password.


     *


     * @param string $attribute the attribute currently being validated


     * @param array $params the additional name-value pairs given in the rule


     */


    public function validatePassword($attribute, $params)


    {


        if (!$this->hasErrors()) {


            $user = $this->getUser();





            if (!$user || !$user->validatePassword($this->password)) {


                Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'Helytelen email cím jelszó páros.'));


                $this->addError($attribute, Yii::t('app', 'Helytelen email cím jelszó páros.'));


            }


        }


    }





    /**


     * Logs in a user using the provided username and password.


     * @return boolean whether the user is logged in successfully


     */


    public function login()


    {


        if ($this->validate()) {


            $user=$this->getUser();


            //Yii::$app->extra->e(($user->status==Usermodule::STATUS_NOACTIVE));


            if($user->banned || $user->bantime!=0) 


            {


                if($user->banned) { Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'Felhasználói profilja letiltva.')); }


                else { Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'Felhasználói profilja letiltva. Feloldás ideje: ').  date("Y-m-d H:i:s",$user->bantime)); }


                return false;


            } /*elseif(strtotime($user->regdate)<(time()-(Usermodule::$activation_time)) && $user->status==Usermodule::STATUS_NOACTIVE)  {


                Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'Regisztrációja nem aktív! Először aktiválja a kiküldött email alapján.'));


                return false;


            }*///////// nem figyelem az aktiválást


            


            ////nyelv váltás


            Yii::$app->language = $user->lang_code;


            if(Yii::$app->language != Yii::$app->request->cookies->getValue(Yii::$app->params['langCookiename'])) {


                Yii::$app->response->cookies->remove(Yii::$app->params['langCookiename']);


                $cookie = new \yii\web\Cookie([


                    'name' => Yii::$app->params['langCookiename'],


                    'domain' => '',


                    'value' => Yii::$app->language,


                    'expire' => time() + 86400 * Yii::$app->params['langExpiredays']


                ]);


                Yii::$app->response->cookies->add($cookie);


            }


            //////


            


            


            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? Usermodule::$rememberMeTime : 0);


        } else {


            return false;


        }


    }





    /**


     * Finds user by [[username]]


     *


     * @return User|null


     */


    public function getUser()


    {


        if (substr($_SERVER['REQUEST_URI'], 0,7)=='/admin/') {


            if ($this->_user === false) {


                $this->_user = Users::findadminByUsername($this->username);


            }





            if ($this->_user == false) {





                $this->_user = Users::findadminByEmail($this->username);


            }


        } else {


            if ($this->_user === false) {


                $this->_user = Users::findByUsername($this->username);


            }





            if ($this->_user == false) {





                $this->_user = Users::findByEmail($this->username);


            }


        }





        return $this->_user;


    }


}