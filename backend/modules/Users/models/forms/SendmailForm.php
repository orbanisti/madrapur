<?php

backend\

namespace app\modules\Users\models\forms;


backend\
use backend\
backend\
use backend\helpers\Html;

use yii\base\Model;

use app\modules\Users\models\Users;

use app\modules\Mailtemplates\models\MailTemplates;

use app\components\extra;

use app\modules\Users\Module as Usermodule;



/**

 * LoginForm is the model behind the login form.

 */

class SendmailForm extends Model

{

    public $email;



    private $_user = false;



    /**

     * @return array the validation rules.

     */

    public function rules()

    {

        return [

            [['email'], 'required'],

            ['email', 'email'],

        ];

    }

    

    /**

     * Logs in a user using the provided username and password.

     * @return boolean whether the user is logged in successfully

     */

    public function sendmail()

    {

        if ($this->validate()) {

            $user=$this->getUser();



            if(empty($user)) 

            {

                Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'Nincs ilyen email cím regisztrálva.'));

                return false;

            } elseif($user->status!=Usermodule::STATUS_NOACTIVE) {

                Yii::$app->getSession()->setFlash('error',  Yii::t('app', 'A profilja már aktiválva van.'));

                return false;

            } else {

                $activation_url = Yii::$app->getUrlManager()->createAbsoluteUrl(['/users/activation/activation',"activkey" => $user->hashcode, "email" => $user->email]);

                $mailTemplate = MailTemplates::getTemplate(1,Yii::$app->language);

                $activation_link = Html::a($activation_url, $activation_url);

                $name = $user->username;

                $body = str_replace(['[link]', '[username]'], [$activation_link, $name], $mailTemplate);



                extra::sendMail($user->email, Yii::t('app', 'Regisztráció megerősítése'),$body);

                return true;

            }

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

        if ($this->_user === false) {

            $this->_user = Users::findByEmail($this->email);

        }



        return $this->_user;

    }

}