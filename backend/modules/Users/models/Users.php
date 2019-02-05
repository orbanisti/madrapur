<?php

namespace backend\modules\Users\models;

use Yii;

use backend\modules\Users\Module as Usermodule;
use backend\modules\Users\models\Userpartners;
use yii\helpers\ArrayHelper;
use backend\modules\Products\models\Products;
use backend\modules\Order\models\Orderedproducts;
use backend\models\Shopcurrency;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'status', 'type'], 'required'],
            [['regdate'], 'safe'],
            [['agree_upload_info', 'payment_in_advance', 'status', 'rights', 'type', 'fb_id', 'dividend', 'commission_type', 'contract'], 'integer'],
            [['email', 'username'], 'string', 'max' => 255],
            [['commission'], 'number'],
            [['password', 'hashcode'], 'string', 'max' => 32],
            [['lang_code'], 'string', 'max' => 5],
            [['comment'], 'string', 'max' => 1000],
            ['email', 'email'],
            [['email'], 'unique'],
            [['username'], 'unique']
        ]; 
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fb_id' => Yii::t('app', 'Facebook ID'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Felhasználónév'),
            'password' => Yii::t('app', 'Jelszó'),
            'regdate' => Yii::t('app', 'Regisztráció dátuma'),
            'status' => Yii::t('app', 'Státusz'),
            'hashcode' => Yii::t('app', 'Aktív kulcs'),
            'rights' => Yii::t('app', 'Felhasználó jogok'),
            'type' => Yii::t('app', 'Típus'),
            'lang_code' => Yii::t('app', 'Nyelv kód'),
            'dividend' => Yii::t('app', 'Jutalék'),
            'dividendprice' => Yii::t('app', 'Jutalék összege'),
            'payment_in_advance' => Yii::t('app', 'Előre fizetés'),
            'agree_upload_info' => Yii::t('app', 'Feltöltési feltétel elfogadása'),
            'comment' => Yii::t('app', 'Megjegyzés'),
            'commission_type' =>  Yii::t('app', 'Jutalék típusa'),
            'commission' =>  Yii::t('app', 'Jutalék'),
            'contract' =>  Yii::t('app', 'Szerződés'),
        ];
    }

    public function beforeDelete() {
        parent::beforeDelete();

        foreach (Products::find()->where(['user_id'=>$this->id])->all() as $prod)
        {
            Products::updateAll([
                    'user_id' => 195,
                    'status' => Products::STATUS_INACTIVE,
                ], 'id='.$prod->id);
        }

        return true;
    }

    public static function findIdentity($id) {
        $user = self::find()
            ->where([
                "id" => $id
            ])
            ->one();
        if (is_array($user) && !count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findIdentityByAccessToken($token, $userType = null) {

        $user = self::find()
                ->where(["accessToken" => $token])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findByUsername($username) {
        $user = self::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findByEmail($email) {
        $user = self::find()
                ->where([
                    "email" => $email
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findadminByUsername($username) {

        $user = self::find()
                ->where(
                    'username = :username AND rights != :rights',
                    ['username'=>$username, 'rights'=>Usermodule::RIGHT_USER]
                )
                ->one();
    
        if (is_array($user) && !count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findadminByEmail($email) {

        $user = self::find()
                ->where(
                    'email = :email AND rights != :rights',
                    ['email'=>$email, 'rights'=>Usermodule::RIGHT_USER]
                )
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    public static function findUsernamebyid($id) {
        $user = self::findOne($id);
        if (!count($user)) {
            return '';
        }
        return $user->username;
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->hashcode;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password) {
        return $this->password === Yii::$app->getModule('users')->encrypting($password);
    }

    public function getBans()
    {
        return $this->hasMany(Bans::className(), ['userid' => 'id']);
    }

    public function getBanned()
    {
        if($this->status==Usermodule::STATUS_BANNED) return true;
        return false;
    }

    public function getBantime()
    {
        //$bantime=$this->hasOne(Bans::className(), ['userid' => 'id'])->orderBy(['bans.endban'=>SORT_DESC]);
        $bantime=Bans::find()->where(['userid'=>$this->id])->orderBy(['bans.endban'=>SORT_DESC])->one();
        if(!empty($bantime) && $bantime->endban>time())
            return $bantime->endban;
        else
            return 0;
    }

    public function getLoginhistories()
    {
        return $this->hasMany(Loginhistory::className(), ['userid' => 'id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['userid' => 'id']);
    }

    public function getTermsconditions()
    {
        return $this->hasOne(Usertermsconditions::className(), ['user_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['referrer' => 'id']);
    }

    public function getPartnersbyid($id)
    {
        return Userpartners::find()->where('user_id='.$id)->all();
    }

    public function getPartnerbyid($id)
    {
        return Userpartners::find()->where('partner_id='.$id)->all();
    }

    public function getNotificationemail()
    {
        return ($this->profile->email!='')?$this->profile->email:$this->email;
    }

    public function getDividendprice()
    {
        $dividendprice=0; $dprice=0;
        $products=Products::getUserproductsidstodividend($this->id);
        $orderedproducts=Orderedproducts::find()->where(['product_id'=>$products])->all();
        foreach($orderedproducts as $product)
        {
            $dprice=0;
            $price=Shopcurrency::valueBycurrency($product->sum_price,$product->order->currency);
            $prod=$product->product;
            if($prod->commission!=0) { //ha van megadva a temékhez jutalék
                switch ($prod->commission_type) {
                    case Products::COMMTYPE_PERCENT: {
                        $dprice=($price/100)*$prod->commission;
                        break;
                    }
                    case Products::COMMTYPE_VALUE: {
                        $dprice=$prod->commission;
                        break;
                    }
                    case Products::COMMTYPE_NETGROSS: {
                        $netprice=0; $grprice=0;
                        foreach ($product->ticket as $ticket) {
                            $netprice=(!empty($ticket['netprice']))?$ticket['netprice']:0;
                            $grprice=(!empty($ticket['price']))?$ticket['price']:0;
                            if($netprice!=0 && $grprice!=0) {
                                $dprice=($grprice-$netprice)*$ticket['amount'];

                            }
                        }
                        break;
                    }
                    default:
                        $dprice=0;
                }
            } else { //ha nincs megadva a temékhez jutalék, akkor a partnerhez beállított értékkel számol
                switch ($this->commission_type) {
                    case Products::COMMTYPE_PERCENT: {
                        $dprice=($price/100)*$this->commission;
                        break;
                    }
                    case Products::COMMTYPE_VALUE: {
                        $dprice=$this->commission;
                        break;
                    }
                    case Products::COMMTYPE_NETGROSS: {
                        $netprice=0; $grprice=0;
                        foreach ($product->ticket as $ticket) {
                            $netprice=(!empty($ticket['netprice']))?$ticket['netprice']:0;
                            $grprice=(!empty($ticket['price']))?$ticket['price']:0;
                            if($netprice!=0 && $grprice!=0) {
                                $dprice=($grprice-$netprice)*$ticket['amount'];
                            }
                        }
                        break;
                    }
                    default:
                        $dprice=0;
                }
            }
            $dividendprice+=$dprice;
        }
        return $dividendprice;
    }

    public static function getDropdownlist()
    {
        return ArrayHelper::map(self::find()/*->where(['status'=>1])*/->all(), 'id', 'username');
    }

}

