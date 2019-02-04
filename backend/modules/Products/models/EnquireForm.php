<?phpnamespace backend\modules\Products

namespace app\modules\Products\models;

use Yii;
use yii\base\Model;

class EnquireForm extends Model
{

    public $name;
    public $email;
    public $body;
    public $product_id;
    public $verifyCode;

    public function rules()
    {
        return [

            [['name', 'email'], 'required'],
            ['email', 'email'],
            [['product_id'], 'integer'],
            [['body'], 'safe'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' =>  Yii::t('app', 'Név'),
            'email' =>  Yii::t('app', 'Email cím'),
            'body' =>  Yii::t('app', 'Üzenet'),
            'verifyCode' =>  Yii::t('app', 'Ellenörző kód'),
        ];
    }

}


