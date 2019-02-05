<?phpbackend\backend\

namespace app\modules\Users\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use zxbodya\yii2\imageAttachment\ImageAttachmentBehavior;
use app\modules\Users\Module as Usermodule;

class Profile extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'profile';
    }

    public function rules()
    {
        return [
            //[['userid', 'first_name', 'last_name', 'phone', 'image', 'about', 'country', 'zipcode', 'city', 'address', 'billing_country', 'billing_zipcode', 'billing_city', 'billing_address'], 'required'],
            [['userid'], 'integer'],
            [['about'], 'string'],
            [['email', 'first_name', 'last_name', 'address', 'billing_address'], 'string', 'max' => 255],
            ['email', 'email'],
            [['company_name'], 'string', 'max' => 500],
            [['phone', 'country', 'city', 'billing_country', 'billing_city'], 'string', 'max' => 128],
            [['image','logo'], 'string', 'max' => 100],
            [['zipcode', 'billing_zipcode'], 'string', 'max' => 32],
            [['tax_code', 'bank_acc_number', 'reg_code'], 'string', 'max' => 200],
            [['comment'], 'string', 'max' => 2000],
            [['tax_code','bank_acc_number','reg_code'], 'required', 'when' => function ($model) {
                return $model->type == Usermodule::TYPE_PARTNER;
            }
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userid' => Yii::t('app', 'Felhasználó'),
            'first_name' => Yii::t('app', 'Keresztnév'),
            'last_name' => Yii::t('app', 'Vezetéknév'),
            'phone' => Yii::t('app', 'Telefonszám'),
            'image' => Yii::t('app', 'Profilkép'),
            'about' => Yii::t('app', 'Bemutatkozás'),
            'country' => Yii::t('app', 'Ország'),
            'zipcode' => Yii::t('app', 'Irányítószám'),
            'city' => Yii::t('app', 'Város'),
            'address' => Yii::t('app', 'Cím'),
            'billing_country' => Yii::t('app', 'Billing Ország'),
            'billing_zipcode' => Yii::t('app', 'Billing Irányítószám'),
            'billing_city' => Yii::t('app', 'Billing Város'),
            'billing_address' => Yii::t('app', 'Billing Cím'),
            'tax_code' => Yii::t('app', 'Adószám'),
            'bank_acc_number' => Yii::t('app', 'Bankszámlaszám'),
            'reg_code' => Yii::t('app', 'Regisztrációs szám'),
            'logo' => Yii::t('app', 'Logó'),
            'company_name' => Yii::t('app', 'Cégnév'),
            'email' => Yii::t('app', 'Értesítések E-mail címe'),
            'comment' => Yii::t('app', 'Megjegyzés'),
        ];
    }

    public function behaviors()
    {
        return [
            //TimestampBehavior::className(),
            'coverBehavior' => [
                'class' => ImageAttachmentBehavior::className(),
                // type name for model
                'type' => 'profile',
                // image dimmentions for preview in widget
                'previewHeight' => 200,
                'previewWidth' => 200,
                // extension for images saving
                'extension' => 'jpg',
                // path to location where to save images
                'directory' => Yii::getAlias('@webroot') . '/images/profile/cover',
                'url' => Yii::getAlias('@web') . '/images/profile/cover',
                // additional image versions
                'versions' => [
                    'small' => function ($img) {
                        /** @var ImageInterface $img */
                        return $img
                            ->copy()
                            ->resize($img->getSize()->widen(200));
                    },
                    'medium' => function ($img) {
                        /** @var ImageInterface $img */
                        $dstSize = $img->getSize();
                        $maxWidth = 800;
                        if ($dstSize->getWidth() > $maxWidth) {
                            $dstSize = $dstSize->widen($maxWidth);
                        }
                        return [
                            $img->copy()->resize($dstSize),
                            ['jpeg_quality' => 100], // options used when saving image (Imagine::save)
                        ];
                    },
                ]
            ]
        ];
    }

    public function getThumb()
    {
        $url='/images/profile/no-pic.jpg';
        if ($this->getBehavior('coverBehavior')->hasImage()) {
            //$url=$this->getBehavior('coverBehavior')->getUrl('original');
            return $this->getBehavior('coverBehavior')->getUrl('preview');
        }
        return Yii::$app->imagecache->createUrl('profile-thumb',$url);
    }

    public function getThumbbase()
    {
        if ($this->getBehavior('coverBehavior')->hasImage()) {
            //$url=$this->getBehavior('coverBehavior')->getUrl('original');
            return Yii::$app->imagecache->createUrl('profilethumb',$this->getBehavior('coverBehavior')->getUrl('preview'));
        }
        return '/img/user.png';
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    public function getLogopicture()
    {
        return ($this->logo!='')?WEB_ROOT.Yii::$app->params['logoPictures'] . $this->logo:'';
    }

    public function getFullname()
    {
        return $this->first_name.' '.$this->last_name;
    }
}