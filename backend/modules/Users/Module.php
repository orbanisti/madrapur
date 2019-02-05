<?php

namespace backend\modules\Users;

use Yii;
use backend\modules\Users\models\Users;
use backend\modules\Users\models\Userpartners;

class Module extends \yii\base\Module
{
    const STATUS_NOACTIVE=0;
    const STATUS_ACTIVE=1;
    const STATUS_BANNED=2;

    public static function status($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'inaktív'),
            1 => Yii::t('app', 'aktív'),
            2 => Yii::t('app', 'kitíltva'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function paymentad($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'Nem'),
            1 => Yii::t('app', 'Igen'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function contract($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'Nem'),
            1 => Yii::t('app', 'Igen'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    const RIGHT_USER=0;
    const RIGHT_MODERATOR=1;
    const RIGHT_FINANCE=2;
    const RIGHT_ADMANAGER=0;

    const TYPE_PERSON=0;
    const TYPE_PARTNER=1;

    public static function type($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'magánszemély'),
            1 => Yii::t('app', 'partner'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public $controllerNamespace = 'backend\modules\Users\controllers';



    public static $hash='md5';

    public static $rememberMeTime = 2592000; // 30 days

    public static $activation_time = 604800; // 7 days



    public static $partnerregistrationUrl = ["/users/registration/partnerregistration"];

    public static $userregistrationUrl = ["/users/registration/userregistration"];

    public static $registrationUrl = ["/users/registration"];

    public static $recoveryUrl = ["/users/recovery/recovery"];

    public static $loginUrl = ["/users/login"];

    public static $loginfbUrl = ["/users/login/loginfb"];

    public static $logoutUrl = ["/users/logout"];

    public static $profileUrl = ["/users/profile"];

    public static $returnUrl = ["/users/profile"];

    public static $returnLogoutUrl = ["/users/login"];

    public static $usersUrl = ["/users/users/index"];



    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';



    public $modelMap = [];



    public function init()

    {

        parent::init();



        // custom initialization code goes here

    }



    /**

     * @return hash string.

     */

    public static function encrypting($string="") {

        if (self::$hash=="md5")

                return md5($string);

        if (self::$hash=="sha1")

                return sha1($string);

        else

                return hash($hash,$string);

    }



    /*public static function userTypes($n=false)

    {

        $tt = [

            0 => Yii::t('app', 'Magánszemély'),

            1 => Yii::t('app', 'Vállakozás'),

        ];

        return ($n===false)? $tt : $tt[$n];

    }*/



    public static function isAdmin()

    {

        if(!Yii::$app->user->isGuest){

            $user=Users::findOne(['username' => Yii::$app->user->identity->username]);

            if (!empty($user) && $user->rights==2){

                return true;

            }

        }

        return false;

    }



    public static function isPartner()

    {

        if(!Yii::$app->user->isGuest){

            $user=Users::findOne(['username' => Yii::$app->user->identity->username]);

            if (!empty($user) && $user->type==self::TYPE_PARTNER){

                return true;

            }

        }

        return false;

    }



    public static function isPartners()

    {

        if(!Yii::$app->user->isGuest){

            $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);

            if (!empty($partner))

            {

                $user=Users::findOne(['id' => $partner->user_id]);

                if (!empty($user) && $user->type==self::TYPE_PARTNER){

                    return true;

                }

            }

        }

        return false;

    }



    public static function isPartnersright($right)

    {

        if(!Yii::$app->user->isGuest){

            $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);

            if (!empty($partner))

            {

                $user=Users::findOne(['id' => $partner->user_id]);

                if (!empty($user) && $user->type==self::TYPE_PARTNER){

                    if($partner->rights>=$right) return true;

                }

            }

        }

        return false;

    }

    public static function getLogineduser()
    {
        return Users::findOne(Yii::$app->user->id);
    }

}

