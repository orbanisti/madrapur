<?php
namespace backend\modules\Products\models;

use Yii;
use backend\modules\Products\models\Productstranslate;
use backend\modules\Products\models\Productscategory;
use yii\helpers\ArrayHelper;
use backend\modules\Users\models\Users;
use backend\components\extra;
use zxbodya\yii2\galleryManager\GalleryBehavior;
use yii\helpers\Json;
use backend\models\Shopcurrency;
use backend\modules\Users\models\Userpartners;
use backend\modules\Products\models\Blockouts;
use backend\modules\Products\models\ProductsTime;
use yii\helpers\Html;
use backend\modules\Mailtemplates\models\MailTemplates;
use backend\modules\Citydescription\models\Countries;
use backend\modules\Citydescription\models\Citydescription;
use backend\modules\Citydescription\models\CitydescriptionTranslate;

class Products extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;

    const SOURCE_MANDELAN=0;
    const SOURCE_GRAYLINE=1;
    const SOURCE_TIQETS=2;
    const SOURCE_GADVENTURERS=3;

    const MODIFIED_NO=0;
    const MODIFIED_YES=1;
    const MODIFIED_NEW=2;

    const COMMTYPE_PERCENT=0;
    const COMMTYPE_VALUE=1;
    const COMMTYPE_NETGROSS=2;

    public $blockoutsdates='';
    public $serviceslist=[];
    public $allowed_days_list=[];
    public $country_list=[];
    public $city_list=[];
    public $country_id;
    public $city_id;
    public $partnercomment;

    public static function status($n=false)
    {
        $tt = [
            1 => Yii::t('app', 'aktív'),
            0 => Yii::t('app', 'inaktív'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function source($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'Mandelan'),
            1 => Yii::t('app', 'Grayline'),
            2 => Yii::t('app', 'Tiqets'),
            3 => Yii::t('app', 'Gadventures'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function durationtype($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'perc'),
            1 => Yii::t('app', 'óra'),
            2 => Yii::t('app', 'nap'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function commissiontypes($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'százalék'),
            1 => Yii::t('app', 'pénznemed'),
            2 => Yii::t('app', 'nettó-bruttó arány'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function modified($n=false)
    {
        $tt = [
            0 => Yii::t('app', 'nem'),
            1 => Yii::t('app', 'igen'),
            2 => Yii::t('app', 'új'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function alloweddays($n=false)
    {
        $tt = [
            1 => Yii::t('app', 'Hétfő'),
            2 => Yii::t('app', 'Kedd'),
            3 => Yii::t('app', 'Szerda'),
            4 => Yii::t('app', 'Csütörtök'),
            5 => Yii::t('app', 'Péntek'),
            6 => Yii::t('app', 'Szombat'),
            7 => Yii::t('app', 'Vasárnap'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function tableName()
    {
        return 'products';
    }

    public function rules()
    {
        return [
            [['country_list', 'city_list', 'commission', 'name', 'description', 'status', 'category_id', 'start_date', 'end_date'], 'required'],
            [['description','other_info'], 'string'],
            [['adventurers_last_modified', 'gadventurers_id', 'enquire_only', 'booking_type', 'country_id','city_id', 'tour_id', 'channel_id', 'source', 'commission_type', 'net_prices', 'number', 'start_date_delay', 'expire_noti', 'creator_id', 'duration', 'duration_type', 'marketplace', 'marketplace_discount', 'modified', 'status', 'category_id', 'time', 'min_participator', 'max_participator', 'highlight', 'highlight_time', 'moderator_rating', 'classification', 'user_id'], 'integer'],
            [['tiqets_rating', 'price', 'commission', 'latitude', 'longitude'], 'number'],
            ['start_date_delay', 'integer', 'min' => 0],
            //[['end_date'], 'date','format' => 'yyyy-M-d HH:mm:ss'],
            [['start_date', 'end_date'], 'date','format' => 'yyyy-M-d'],
            [[/*'country', 'city',*/ 'address', 'link'], 'string', 'max' => 255],
            [['services', 'changed'], 'string', 'max' => 500],
            [['lang_code','currency'], 'string', 'max' => 5],
            [['intro', 'name'], 'string', 'max' => 80],
            [['allowed_days'], 'string', 'max' => 50],
            [['serviceslist', 'country_list'], 'each', 'rule' => ['integer']],
            [['city_list'], 'each', 'rule' => ['string']],
            ['allowed_days_list', 'each', 'rule' => ['integer']],
            [['blockoutsdates'], 'string', 'max' => 8000],
            [['updated'], 'string', 'max' => 10],
            [['gadventurers_product_line'], 'string', 'max' => 16],
            [['tour_url', 'tour_url_tracked', 'book_url'], 'string', 'max' => 300],
            [['partnercomment'], 'string', 'max' => 1000],
            ['marketplace_discount', 'required', 'when' => function ($model) {
                return ($model->marketplace == 1);
            }, 'whenClient' => "function (attribute, value) {
                return ($('#products-marketplace').is(':checked'));
            }"],
            ['marketplace_discount', 'compare', 'compareValue' => -1, 'operator' => '>'],
            ['marketplace_discount', 'compare', 'compareValue' => 0, 'operator' => '>', 'when' => function ($model) {
                return ($model->marketplace == 1);
            }, 'whenClient' => "function (attribute, value) {
                return ($('#products-marketplace').is(':checked'));
            }"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Név'),
            'intro' => Yii::t('app', 'Rövid leírás'),
            'description' => Yii::t('app', 'Leírás'),
            'other_info' => Yii::t('app', 'Fontos információk'),
            'image' => Yii::t('app', 'Kép'),
            'status' => Yii::t('app', 'Státusz'),
            'category_id' => Yii::t('app', 'Kategória'),
            'price' => Yii::t('app', 'Ár'),
            'country' => Yii::t('app', 'Ország'),
            'country_id' => Yii::t('app', 'Ország'),
            'city' => Yii::t('app', 'Város'),
            'city_id' => Yii::t('app', 'Város'),
            'country_list' => Yii::t('app', 'Ország'),
            'city_list' => Yii::t('app', 'Város'),
            'address' => Yii::t('app', 'Cím'),
            'start_date' => Yii::t('app', 'Kezdő dátum'),
            'start_date_delay' => Yii::t('app', 'Rendlési idő késleltetése (nap)'),
            'end_date' => Yii::t('app', 'Érvényességi idő'),
            'time' => Yii::t('app', 'Időtartam'),
            'services' => Yii::t('app', 'Szolgáltatások'),
            'serviceslist' => Yii::t('app', 'Szolgáltatások'),
            'max_participator' => Yii::t('app', 'Max résztvevő'),
            'min_participator' => Yii::t('app', 'Minimum résztvevő'),
            'highlight' => Yii::t('app', 'Kiemelt'),
            'highlight_time' => Yii::t('app', 'Kiemelés időpont'),
            'moderator_rating' => Yii::t('app', 'Moderátor értékelés'),
            'classification' => Yii::t('app', 'Osztályzás'),
            'user_id' => Yii::t('app', 'Felhasználó'),
            'lang_code' => Yii::t('app', 'Nyelv'),
            'link' => Yii::t('app', 'Link'),
            'currency' => Yii::t('app', 'Valuta'),
            'modified' => Yii::t('app', 'Módosítva'),
            'marketplace' => Yii::t('app', 'Piactér'),
            'marketplace_discount' => Yii::t('app', 'Piactér kedvezmény').' ( % )',
            'user' => Yii::t('app', 'Felhasználónév'),
            'duration' => Yii::t('app', 'Időtartam'),
            'duration_type' => Yii::t('app', 'Időtartam típus'),
            'creator_id' => Yii::t('app', 'Létrehozta'),
            'expire_noti' => Yii::t('app', 'Lejárat értesítő'),
            'allowed_days' => Yii::t('app', 'Engedélyezett napok'),
            'blockoutsdates' =>  Yii::t('app', 'Dátumok'),
            'number' =>  Yii::t('app', 'Sorszám'),
            'net_prices' =>  Yii::t('app', 'Nettó árak'),
            'latitude' =>  Yii::t('app', 'Szélességi fok'),
            'longitude' =>  Yii::t('app', 'Hosszúsági fok'),
            'commission_type' =>  Yii::t('app', 'Jutalék típusa'),
            'commission' =>  Yii::t('app', 'Jutalék'),
            'channel_id' => Yii::t('app', 'Grayline'),
            'tiqets_id' => Yii::t('app', 'Tiqets ID'),
            'tiqets_rating' => Yii::t('app', 'Tiqets értékelés'),
            'source' => Yii::t('app', 'Forrás'),
            'booking_type' => Yii::t('app', 'Rendelés'),
            'enquire_only' => Yii::t('app', 'Csak ajánlat kérés'),
            'partnercomment' => Yii::t('app', 'Partner megjegyzés'),
        ];
    }

    public function behaviors()
    {
        return [
            'galleryBehavior' => [
                'class' => GalleryBehavior::className(),
                'type' => 'products',
                'extension' => 'jpg',
                'tableName' => 'products_gallery',
                'directory' => WEB_ROOT . '/images/products/gallery',
                'url' => '/images/products/gallery',
                'versions' => [
                    'small' => function ($img) {
                        // @var \Imagine\Image\ImageInterface $img
                        return $img
                            ->copy()
                            ->thumbnail(new \Imagine\Image\Box(200, 200));
                    },
                    'medium' => function ($img) {
                        //@var Imagine\Image\ImageInterface $img
                        $dstSize = $img->getSize();
                        $maxWidth = 800;
                        if ($dstSize->getWidth() > $maxWidth) {
                            $dstSize = $dstSize->widen($maxWidth);
                        }
                        return $img
                            ->copy()
                            ->resize($dstSize);

                    },
                ]
            ]
        ];
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        /*$country_list=implode(',', $this->country_list);
        $prodid=($this->isNewRecord)?0:$this->id;
        Productscountires::deleteAll('product_id='.$prodid.' AND country_id NOT IN ('.$country_list.')');
        foreach($this->country_list as $id){
            $prodc=Productscountires::find()->where(['product_id'=>$prodid,'country_id'=>$id])->one();
            if(empty($prodc)) {
                $pr = new Productscountires();
                $pr->country_id=$id;
                $pr->product_id=$prodid;
                $pr->save(false);
            }
        }

        //$country_list=implode(',', $this->city_list);
        $country_list=[];
        foreach($this->city_list as $cl) {
            if(is_numeric($cl)) $country_list[]=$cl;
        }
        $country_list=implode(',', $country_list);

        Productscities::deleteAll('product_id='.$prodid.' AND city_id NOT IN ('.$country_list.')');
        //Yii::$app->extra->e($this->city_list);
        foreach($this->city_list as $id){
            $prodc='';
            if(is_numeric($id)) {
                $prodc=Productscities::find()->where(['product_id'=>$prodid,'city_id'=>$id])->one();
            } else {
                $cit=Citydescription::find()->where('title = "'.$id.'"')->one();
                if(!empty($cit))
                    $prodc=Productscities::find()->where(['product_id'=>$prodid,'city_id'=>$cit->id])->one();
            }
            if(empty($prodc)) {
                $pr = new Productscities();
                if(is_numeric($id)) {
                    $pr->city_id=$id;
                } else {
                    $city = new Citydescription();
                    $city->title = $id;
                    $city->country_id = 255; //új város
                    $city->save(false);

                    $pr->city_id=$city->id;
                }
                $pr->product_id=$prodid;
                $pr->save(false);
            }
        }*/

        if(empty($this->marketplace_discount)) $this->marketplace_discount=0;

        if($this->isNewRecord) {
            $max=self::find()->max('number');
            $this->number=$max+1;
        }

        $this->link = extra::stringToUrl($this->name);
        $this->services=Json::encode($this->serviceslist);
        $this->allowed_days=Json::encode($this->allowed_days_list);
        if($this->duration=='')$this->duration=0;
        $this->expire_noti=0;

        if($this->user_id!=205 && $this->user_id!=214 && $this->user_id!=226) { ////ha nem grayline, tiqets és gadventurers import
            if(Yii::$app->getModule('users')->isAdmin()) {
                $this->modified=self::MODIFIED_NO;
                $this->changed='';

                if(!$this->isNewRecord && $this->OldAttributes['status']==self::STATUS_INACTIVE && $this->status==self::STATUS_ACTIVE) {
                    $uid=($this->creator_id!=0)?$this->creator_id:$this->user_id;
                    $user=Users::findOne($this->creator_id);
                    if(!empty($user)) {
                        $mailTemplate = MailTemplates::getTemplate(6,$user->lang_code);
                        $body = str_replace(['[username]', '[link]'], [$user->username, Html::a($this->name,'http://mandelan.eu/product/'.$this->id.'/'.$this->link)], $mailTemplate);
                        extra::sendMail($user->notificationemail, Yii::t('app', 'Termék aktiválva'),$body);
                    }
                }
            } else {
                if($this->isNewRecord) {
                    $this->modified=self::MODIFIED_NEW;
                    $this->status=self::STATUS_INACTIVE;
                    $body='<h3>Új terméket töltöttek fel<h3><br/>';
                    $body.='Név: '.$this->name.'<br/>';
                    $body.='Időpont: '.date('Y-m-d H:i:s', time());
                    extra::sendMail(Yii::$app->params['adminEmail'], Yii::t('app', 'Új terméket töltöttek fel'),$body);
                    extra::sendMail(Yii::$app->params['adminEmailNoti'], Yii::t('app', 'Új terméket töltöttek fel'),$body);
                } else {
                    $this->modified=self::MODIFIED_YES;
                    $this->status=self::STATUS_INACTIVE;

                    $changed=[];
                    //$changed=Json::decode($this->changed);
                    if($this->OldAttributes['name']!=$this->name) $changed[]='Terméknév';
                    if($this->OldAttributes['intro']!=$this->intro) $changed[]='Rövid leírás';
                    if($this->OldAttributes['description']!=$this->description) $changed[]='Leírás';
                    if($this->OldAttributes['other_info']!=$this->other_info) $changed[]='Fontos információk';
                    if($this->OldAttributes['services']!=$this->services) $changed[]='Szolgáltatások';
                    $this->changed=Json::encode($changed);
                }
            }
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        $country_list=implode(',', $this->country_list);
        if($country_list=='')$country_list='0';
        $prodid=$this->id;
        Productscountires::deleteAll('product_id='.$prodid.' AND country_id NOT IN ('.$country_list.')');
        foreach($this->country_list as $id){
            $prodc=Productscountires::find()->where(['product_id'=>$prodid,'country_id'=>$id])->one();
            if(empty($prodc)) {
                $pr = new Productscountires();
                $pr->country_id=$id;
                $pr->product_id=$prodid;
                $pr->save(false);
            }
        }

        //$country_list=implode(',', $this->city_list);
        $city_list=[];
        foreach($this->city_list as $cl) {
            if(is_numeric($cl)) $city_list[]=$cl;
        }
        $city_list=implode(',', $city_list);
        if($city_list=='')$city_list='0';
        Productscities::deleteAll('product_id='.$prodid.' AND city_id NOT IN ('.$city_list.')');
        //Yii::$app->extra->e($this->city_list);
        foreach($this->city_list as $id){
            $prodc='';
            if(is_numeric($id)) {
                $prodc=Productscities::find()->where(['product_id'=>$prodid,'city_id'=>$id])->one();
            } else {
                $cit=Citydescription::find()->where('title = "'.$id.'"')->one();
                if(!empty($cit))
                    $prodc=Productscities::find()->where(['product_id'=>$prodid,'city_id'=>$cit->id])->one();
            }
            if(empty($prodc)) {
                $pr = new Productscities();
                if(is_numeric($id)) {
                    $pr->city_id=$id;
                } else {
                    $city=Citydescription::find()->where('title = "'.$id.'"')->one();
                    if(empty($city)) {
                        $cityt=CitydescriptionTranslate::find()->where('title = "'.$id.'"')->one();
                        if(!empty($cityt))
                            $city=Citydescription::findOne($cityt->citydescription_id);
                    }
                    if(empty($city)) { // ha nem találok ilyen várost akkor újat hozok létre
                        $city = new Citydescription();
                        $city->title = $id;
                        $city->country_id = 255; //új város
                        $city->save(false);
                    }

                    $pr->city_id=$city->id;
                }
                $pr->product_id=$prodid;
                $pr->save(false);
            }
        }

        $blockouts=$this->blockouts;

        if(empty($blockouts)) {
            $blockouts = new Blockouts;
            $blockouts->product_id=$this->id;
            $blockouts->dates=$this->blockoutsdates;
            $blockouts->save(false);
        } else {
            $blockouts->dates=$this->blockoutsdates;
            $blockouts->save(false);
        }

        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        if(Yii::$app->controller->action->id=='create' || Yii::$app->controller->action->id=='admin' || Yii::$app->controller->action->id=='update') {
            $this->country_list=$this->countryids;
            $this->city_list=$this->cityids;
        }


        //if(Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))
        $translation=$this->translation;
        if((Yii::$app->language!=$this->lang_code && !empty($translation)) && (Yii::$app->controller->action->id!='myproducts' && Yii::$app->controller->action->id!='admin' && Yii::$app->controller->action->id!='update'))
            $this->attributes=$translation->attributes;

        if(Yii::$app->controller->action->id=='view' || Yii::$app->controller->action->id=='create' || Yii::$app->controller->action->id=='admin' || Yii::$app->controller->action->id=='update') {
            $this->serviceslist=Json::decode($this->services);
            $this->allowed_days_list=Json::decode($this->allowed_days);
        }

        if(Yii::$app->controller->action->id=='admin' && !empty($this->user->comment)) $this->partnercomment=$this->user->comment;
    }

    public function beforeDelete() {
        parent::beforeDelete();
        Productstranslate::deleteAll(['product_id'=>$this->id]);
        Productsprice::deleteAll(['product_id'=>$this->id]);
        Productsopinion::deleteAll(['product_id'=>$this->id]);
        Blockouts::deleteAll(['product_id'=>$this->id]);

        return true;
    }

    public function afterDelete() {
        parent::afterDelete();

        /*$i=1;
        foreach(Products::find()->All() as $product) {
            self::updateAll([
                    'number' => $i,
                ], 'id='.$product->id);
            $i++;
        }*/

        return true;
    }

    public static function createPdf($id){
        $model = Products::findOne($id);
        if(!empty($model)) {
            $template='';
            $template = '<h1>'.$model->name.'</h1><br/>';
            $template .= $model->intro.'<br/>';
            $template .= $model->other_info.'<br/>';
            $services=Services::getServicesbyids($model->serviceslist);
                if(count($services)>0) {
                    $template .= Yii::t('app','Szolgáltatások').'<ul>';
                    foreach ($services as $service){
                        $template .= '<li>'.$service->name.'</li>';
                    }
                    $template .= '</ul>';

                    }
            $template .= '<br/>';
            $template .= Html::img($model->thumb);
            $i=0;
            foreach ($model->getBehavior('galleryBehavior')->getImages() as $image) {
                $i++; $template .= Html::img(Yii::$app->imagecache->createUrl('product-thumb', $image->getUrl("original")));
                if($i==3) break;
            }

            $pdf = Yii::$app->pdf;
            $mpdf = new $pdf->api;
            $mpdf->WriteHtml($template);
            $fname='product-'.$id.'.pdf';
            $mpdf->Output(WEB_ROOT.'/pdf/'.$fname, 'F');
            return WEB_ROOT.'/pdf/'.$fname;
        }
        return false;
    }

    public static function getDropdowncategories()
    {
        $categories=Productscategory::find()->where("status=".Products::STATUS_ACTIVE)->select(['id','name'])->asArray()->all();
        $categories=ArrayHelper::map($categories, 'id', 'name');

        return $categories;
    }

    public static function getDropdowncategoriestoadmin()
    {
        $categories=Productscategory::find()->where("status=".Products::STATUS_ACTIVE)->select(['id','name'])->all();
        $categories=ArrayHelper::map($categories, 'id', 'name');
        $categories=ArrayHelper::merge($categories,[40=>'Import']);
        return $categories;
    }

    public function getSmallthumb()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].$this->image))
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'b/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].'b/'.$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'c/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].'c/'.$this->image);
        else
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].'no-product-pic.jpg');
    }

    public function getThumb()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].$this->image))
            return Yii::$app->imagecache->createUrl('product-thumb',Yii::$app->params['productsPictures'].$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'b/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-thumb',Yii::$app->params['productsPictures'].'b/'.$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'c/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-thumb',Yii::$app->params['productsPictures'].'c/'.$this->image);
        else
            return Yii::$app->params['productsPictures'].'no-product-pic-thumb.png';
    }



    public function getOgthumb()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].$this->image))
            return \yii\helpers\Url::home(true).substr(Yii::$app->imagecache->createUrl('product-ogthumb',Yii::$app->params['productsPictures'].$this->image),1);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'b/'.$this->image))
            return \yii\helpers\Url::home(true).substr(Yii::$app->imagecache->createUrl('product-ogthumb',Yii::$app->params['productsPictures'].'b/'.$this->image),1);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'c/'.$this->image))
            return \yii\helpers\Url::home(true).substr(Yii::$app->imagecache->createUrl('product-ogthumb',Yii::$app->params['productsPictures'].'c/'.$this->image),1);
        else
            return \yii\helpers\Url::home(true).substr(Yii::$app->params['productsPictures'].'no-product-pic-thumb.png',1);
    }
    public function getMedium()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].$this->image))
            return Yii::$app->imagecache->createUrl('product-medium',Yii::$app->params['productsPictures'].$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'b/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-medium',Yii::$app->params['productsPictures'].'b/'.$this->image);
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'c/'.$this->image))
            return Yii::$app->imagecache->createUrl('product-medium',Yii::$app->params['productsPictures'].'c/'.$this->image);
        else
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].'no-product-pic.jpg');
    }

    public function getPicture()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].$this->image))
            return Yii::$app->params['productsPictures'].$this->image;
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'b/'.$this->image))
            return Yii::$app->params['productsPictures'].'b/'.$this->image;
        elseif($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['productsPictures'].'c/'.$this->image))
            return Yii::$app->params['productsPictures'].'c/'.$this->image;
        else
            return Yii::$app->imagecache->createUrl('product-smallthumb',Yii::$app->params['productsPictures'].'no-product-pic.jpg');
    }

    public function getBlockouts()
    {
        return $this->hasOne(Blockouts::className(), ['product_id' => 'id']);
    }

    public function getDescriptionListCategories()
    {
        return $this->hasMany(DescriptionListCategory::className(), ['product_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(ProductsCategory::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getGraylinepartner()
    {
        return $this->hasOne(Graylinepartners::className(), ['channel' => 'channel_id']);
    }

    public function getOpinions()
    {
        return $this->hasMany(Productsopinion::className(), ['product_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    public function getOpinionsaverage()
    {
        return $this->hasMany(Productsopinion::className(), ['product_id' => 'id'])->average('rating');
    }

    public function getOpinionscount()
    {
        return $this->hasMany(Productsopinion::className(), ['product_id' => 'id'])->count();
    }

    public function getPrices()
    {
        return $this->hasMany(Productsprice::className(), ['product_id' => 'id']);
    }

    public function getTimes()
    {
        return $this->hasMany(ProductsTime::className(), ['product_id' => 'id']);
    }

    public function getTimestodropdown()
    {
        return ArrayHelper::map(ProductsTime::find()->where('product_id='.$this->id.' AND (all_time=1 OR (start_date<='.date('Y-m-d').' AND end_date>='.date('Y-m-d').'))')->select('id,name')->asArray()->all(),'id','name');
    }

    public function getMinimalprice()
    {
        //$price=Productsprice::find()->where(['product_id' => $this->id])->orderBy(['price' => SORT_ASC])->one();
        //if(empty($price)) return Shopcurrency::valueBycurrency($this->price,$this->currency);
        //return $price->price;
        //$price=($this->net_prices==1)?round($this->price*(1+(Yii::$app->params['tax']/100)),2):$this->price;
        $price=$this->price;
        if($this->price==0) {
            $prices=Productsprice::find()->where(['product_id' => $this->id])->andWhere(['<>','price',0])->orderBy(['price' => SORT_ASC])->select('price')->asArray()->one();
            if(!empty($prices['price'])) $price=$prices['price'];
        }
        if($this->marketplace==1){
            return Shopcurrency::valueBycurrency($price*((100-$this->marketplace_discount)/100),$this->currency);
        } else {
            return Shopcurrency::valueBycurrency($price,$this->currency);
        }
    }

    public function getMinimalpricenomp()
    {
        //$price=($this->net_prices==1)?round($this->price*(1+(Yii::$app->params['tax']/100)),2):$this->price;
        $price=$this->price;
        if($this->price==0) {
            $prices=Productsprice::find()->where(['product_id' => $this->id])->andWhere(['<>','price',0])->orderBy(['price' => SORT_ASC])->select('price')->asArray()->one();
            if(!empty($prices['price'])) $price=$prices['price'];
        }
        return Shopcurrency::valueBycurrency($price,$this->currency);
    }

    public function getMinimalpricetosave()
    {
        $minprice=$this->price;
        $price=Productsprice::find()->where(['product_id' => $this->id])->andWhere(['<>','price',0])->orderBy(['price' => SORT_ASC])->select('price')->asArray()->one();
        if(!empty($price)) $minprice=$price['price'];

        //return ($this->net_prices==1)?round($minprice*(1+(Yii::$app->params['tax']/100)),2):$minprice;
        return $minprice;
    }

    public static function getCitylisttoac()
    {
        $cities=[];//self::find()->where('city<>"" AND status='.self::STATUS_ACTIVE)->groupBy('city')->orderBy(['city' => SORT_ASC])->all();
        $citylist=[];
        foreach ($cities as $city){
            $citylist[]=$city->city;
        }
        return Json::encode($citylist);
    }

    public static function getCountrylisttoac()
    {
        $countries=[];//self::find()->where('country<>"" AND status='.self::STATUS_ACTIVE)->groupBy('country')->orderBy(['country' => SORT_ASC])->all();
        $countrylist=[];
        foreach ($countries as $country){
            $countrylist[]=$country->country;
        }
        return Json::encode($countrylist);
    }

    public static function getSearchtoac()
    {
        /*$cities=[];//self::find()->where('city<>"" AND status='.self::STATUS_ACTIVE)->groupBy('city')->orderBy(['city' => SORT_ASC])->all();
        $search=[];
        foreach ($cities as $city){
            $search[]=$city->city;
        }
        $countries=[];//self::find()->where('country<>"" AND status='.self::STATUS_ACTIVE)->groupBy('country')->orderBy(['country' => SORT_ASC])->all();
        foreach ($countries as $country){
            $search[]=$country->country;

        }*/

        $db = Yii::$app->db;
        $names = $db->cache(function ($db){
            return self::find()->where('status='.self::STATUS_ACTIVE)->groupBy('name')->select('name')->orderBy(['name' => SORT_ASC])->all();
        }, 600);
        foreach ($names as $name){
            $search[]=$name['name'];
        }
        return Json::encode($search);
    }

    public function getCountries()
    {
        return $this->hasMany(Countries::className(), ['product_id' => 'id']);
    }

    public function getCountryids()
    {
        $db = Yii::$app->db;
        $countries = $db->cache(function ($db){
            return Productscountires::find()->where(['product_id'=>$this->id])->select('country_id')->asArray()->all();
        }, 600);
        return ArrayHelper::map($countries, 'country_id', 'country_id');
    }

    public static function getActiveids()
    {
        //return ArrayHelper::map(self::find()->where(['status'=>Products::STATUS_ACTIVE])->all(), 'id', 'id');
        $db = Yii::$app->db;
        $actives = $db->cache(function ($db){
            return self::find()->where(['status'=>Products::STATUS_ACTIVE])->select(['id'])->asArray()->all();
        }, 60);
        return ArrayHelper::map($actives, 'id', 'id');
    }

    public function getCountry()
    {
        $country=Productscountires::findOne(['product_id' => $this->id]);
        if(!empty($country)){
            if(isset($country->country->country_name)) return $country->country->country_name;
        }
        return '';
    }

    public function getCity()
    {
        $city=Productscities::findOne(['product_id' => $this->id]);
        if(!empty($city)){
            if(isset($city->city->title)) return $city->city->title;
        }
        return '';
    }

    public function getCities()
    {
        return $this->hasMany(Productscities::className(), ['product_id' => 'id']);
    }

    public function getCityids()
    {
        return ArrayHelper::map(Productscities::find()->where(['product_id'=>$this->id])->all(), 'city_id', 'city_id');
    }

    public function getProductsVideos()
    {
        return $this->hasMany(ProductsVideo::className(), ['product_id' => 'id']);
    }

    public function getTranslations()
    {
        return $this->hasMany(Productstranslate::className(), ['product_id' => 'id']);
    }

    public function getTranslation()
    {
        return Productstranslate::findOne(['product_id' => $this->id, 'lang_code'=>Yii::$app->language]);
    }

    public static function getUrlbyid($id)
    {
        $prod=self::findOne($id);
        if(!empty($prod)) {
            $title=(Yii::$app->language==Yii::$app->sourceLanguage)?$prod->link:extra::stringToUrl($prod->name);
            return Yii::$app->urlManager->createAbsoluteUrl(['products/products/view', 'id'=>$prod->id, 'title'=>$title]);
        }
        return '/';
    }

    public function getUrl()
    {
        $title=(Yii::$app->language==Yii::$app->sourceLanguage)?$this->link:extra::stringToUrl($this->name);
        return Yii::$app->urlManager->createAbsoluteUrl(['products/products/view', 'id'=>$this->id, 'title'=>$title]);
    }

    public function getPdfurl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['products/products/pdf', 'id'=>$this->id]);
    }

    public function getGadossiers()
    {
        return $this->hasOne(Productsgadossiers::className(), ['product_id' => 'id']);
    }

    public function getGadepartures()
    {
        return $this->hasOne(Productsgadepartures::className(), ['product_id' => 'id']);
    }

    public function getCountryurl()
    {
        $country=Productscountires::findOne(['product_id' => $this->id]);
        if(!empty($country)){
            if(isset($country->country)) return $country->country->url;
        }
        return '#';
    }

    public function getCityurl()
    {
        $city=Productscities::findOne(['product_id' => $this->id]);
        if(!empty($city)){
            if(isset($city->city)) return $city->city->url;
        }
        return '#';
    }

    public function getCategoryurl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['products/products/index', 'city'=>'mind', 'country'=>'mind', 'minprice'=>0, 'maxprice'=>0, 'catlist'=>$this->category_id]);
    }

    public static function getUserproducts()
    {
        if(!Yii::$app->user->isGuest){
            $user_id=Yii::$app->user->id;
            if(Yii::$app->getModule('users')->isPartners())
            {
                $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);
                $user_id=$partner->user_id;
            }
            return ArrayHelper::map(Products::find()->where('user_id='.$user_id)->select('id,name')->asArray()->all(),'id','name');
        }
        return [0];
    }

    public static function getUserproductsids()
    {
        if(!Yii::$app->user->isGuest){
            $user_id=Yii::$app->user->id;
            if(Yii::$app->getModule('users')->isPartners())
            {
                $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);
                $user_id=$partner->user_id;
            }
            return ArrayHelper::map(Products::find()->where('user_id='.$user_id)->select('id,id')->asArray()->all(),'id','id');
        }
        return [0];
    }

    public static function getUserproductsidstodividend($user_id)
    {
        return ArrayHelper::map(Products::find()->where('user_id='.$user_id)->select('id,id')->asArray()->all(),'id','id');
    }

    public function getExpired()
    {
        if(strtotime($this->firstavailableday)>strtotime(date('Y-m-d', strtotime($this->end_date)))) return true;
        return false;
    }

    public function getBlocked()
    {
        $time=strtotime(Yii::$app->formatter->asDatetime(time(),'php:Y-m-d'));

        $blockout = $this->blockouts;
        if(!empty($blockout)) {
            foreach(explode(',',$blockout->dates) as $date) {
                if($time==$date) return true;
            }
        }

        return false;
    }

    public function getBlockoutdays()
    {
        $days='';

        $blockout = $this->blockouts;

        if($days!='' && !empty($blockout) && $blockout->dates!='') $days.=',';
        if(!empty($blockout)) $days.=$blockout->dates;

        $daysarr=explode(',', $days);
        $days=''; $days.='"';

        if($this->allowed_days!='' && $this->allowed_days!='""')
        {
            $avdate=date('Y-m-d',strtotime($this->start_date));
            do {
                //Yii::$app->extra->e(date('N', strtotime($avdate)).' - '.$avdate);
                if(!in_array(date('N', strtotime($avdate)),$this->allowed_days_list) && !in_array($avdate,$daysarr))
                {
                    $daysarr[]=$avdate;
                }
                $avdate=Yii::$app->formatter->asDatetime((strtotime("+1 day",strtotime($avdate))),'php:Y-m-d');
            } while(strtotime($avdate)<=strtotime(date('Y-m-d',strtotime($this->end_date))));
        }

        $days.=implode('","', $daysarr);
        $days.='"';
        return $days;
    }

    public function getFirstavailableday()
    {
        $days=[];
        $currdate=Yii::$app->formatter->asDatetime(strtotime("+".$this->start_date_delay." day",time()),'php:Y-m-d');
        $avdate=$currdate;

        $blockout = $this->blockouts;

        if(!empty($blockout)) {
            foreach(explode(',',$blockout->dates) as $date) {
                $days[$date]=$date;
            }
        }

        if($this->allowed_days!='' && $this->allowed_days!='""')
        {
            $vdate=date('Y-m-d',strtotime($this->start_date));
            do {
                //Yii::$app->extra->e(date('N', strtotime($avdate)).' - '.$avdate);
                if(!in_array(date('N', strtotime($vdate)),$this->allowed_days_list) && !in_array($vdate,$days))
                {
                    $days[$vdate]=$vdate;
                }
                $vdate=Yii::$app->formatter->asDatetime((strtotime("+1 day",strtotime($vdate))),'php:Y-m-d');
            } while(strtotime($vdate)<=strtotime(date('Y-m-d',strtotime($this->end_date))));
        }

        if(!isset($days[$currdate]) && strtotime($currdate)>strtotime($this->start_date)) return $currdate;
        do {
            $avdate=Yii::$app->formatter->asDatetime((strtotime("+1 day",strtotime($avdate))),'php:Y-m-d');
        } while(isset($days[$avdate]));

        if(strtotime($avdate)<strtotime($this->start_date)) $avdate=$this->start_date;

        return $avdate;
    }
}