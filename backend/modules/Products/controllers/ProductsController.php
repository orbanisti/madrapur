<?phpnamespace backend\modules\Products

namespace app\modules\Products\controllers;

use Yii;
use app\modules\Products\models\Products;
use app\modules\Products\models\Productstranslate;
use app\modules\Products\models\ProductsSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use zxbodya\yii2\galleryManager\GalleryManagerAction;
use lajax\translatemanager\models\Language;
use app\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\components\extra;
use app\modules\Products\models\Productsprice;
use app\modules\Products\models\Productspricetranslate;
use app\modules\Users\models\Userpartners;
use yii\helpers\Html;
use app\modules\Products\models\Services;
use app\modules\Products\models\ProductsadminSearch;
use app\modules\Products\models\ProductsTime;
use yii\helpers\Json;
use app\modules\Citydescription\models\CitydescriptionSearch;
use app\modules\Products\models\Productscities;
use app\modules\Products\models\Productscountires;
use app\modules\Citydescription\models\Countries;
use app\modules\Citydescription\models\Countriestranslate;
use app\modules\Mailtemplates\models\MailTemplates;
use app\modules\Users\Module as Usermodule;
use app\modules\Citydescription\models\CitydescriptionTranslate;
use app\modules\Citydescription\models\Citydescription;
use app\modules\Meta\models\Meta;
use app\modules\Products\models\EnquireForm;
use app\modules\Users\models\Users;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['expireproducts','view','index','search','pdf','marketplace','enquire','gettimes','searchtoac'],
                        'allow' => true,
                        /*'roles' => ['*'],*/
                    ],
                    [
                        'actions' => ['uploadinfo', 'create','galleryApi','myproducts'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->getModule('users')->isAdmin() || Yii::$app->getModule('users')->isPartner() || Yii::$app->getModule('users')->isPartners()) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->getModule('users')->isAdmin() || $this->isUserAuthor()) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->getModule('users')->isAdmin();
                        }
                    ],
                    /*[
                        'actions' => ['create','delete'],
                        'allow' => false,
                    ],*/
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    protected function isUserAuthor()
    {
        $model=$this->findModel(Yii::$app->request->get('id'));
        $partners=Userpartners::find()->where(['user_id'=>$model->user_id,'partner_id'=>Yii::$app->user->id])->one();
        if($model->user_id == Yii::$app->user->id || !empty($partners)) return true;
        return false;
    }

    public function actionSearchtoac()
    {
        /*$names=self::find()->where('status='.self::STATUS_ACTIVE)->groupBy('name')->select('name')->orderBy(['name' => SORT_ASC])->all();

        $i=0;
        foreach ($names as $name){
            $search[$i]['value']=$name['name'];
            $search[$i]['data']=$name['name'];
            $i++;
        }

        Yii::$app->response->format = 'json';
        return Json::encode($search);*/

        if (Yii::$app->request->isAjax) {

            $key=Yii::$app->request->get('q');
            $names=Products::find()->where(['status'=>Products::STATUS_ACTIVE])->andWhere(['LIKE','name',$key])->groupBy('name')->select('name')->orderBy(['name' => SORT_ASC])->limit(10)->all();

            foreach($names as $model) {
               $results[] = [
                    'value' => $model['name'],
                    'data' => $model['name'],
                ];
            }

            return Json::encode($results);
        }
    }

    public function actionGettimes()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $prodid=Yii::$app->request->post('prodid');
            $date=Yii::$app->request->post('date');

            $times=ArrayHelper::map(ProductsTime::find()->where('product_id='.$prodid.' AND (all_time=1 OR (start_date<="'.$date.'" AND end_date>="'.$date.'"))')->select('id,name')->asArray()->all(),'id','name');
            if(!empty($times))
            {
                $timesstr='';
                foreach($times as $key=>$time) {
                    $timesstr.='<option value="'.$key.'">'.$time.'</option>';
                }
                return [
                    'succes' => true,
                    'times' => $timesstr,
                ];
            } else {
                return [
                    'succes' => false,
                    'times' => '<option value="0">'.Yii::t('app','Nincs időpont').'</option>'
                ];
            }
        }
        return false;
    }

    public function actionEnquire()
    {
        $model = new EnquireForm();

        if (Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->post())) {

                $body='<h3>'.Yii::t('app','Új érdeklődő').'</h3><br/>';
                $body.=Yii::t('app','Név').': '.$model->name.'<br/>';
                $body.=Yii::t('app','Email cím').': '.$model->email.'<br/>';
                $body.=Yii::t('app','Üzenet').': '.$model->body.'<br/>';
                $body.=Yii::t('app','Időpont').': '.date('Y-m-d H:i:s', time()).'<br/><br/>';

                $product=Products::findOne($model->product_id);
                $body.=(!empty($product))?Html::a($product->name,$product->url):'';

                Yii::$app->response->format = 'json';
                if(extra::sendMail(Yii::$app->params['enquireEmail'], Yii::t('app','Új érdeklődő'),$body)){
                    return [
                        'succes' => 1,
                        'content' => '<div class="alert alert-success fade in alert-dismissable">'.Yii::t('app','Üzenetét megkaptuk. Hamarosan felvesszük önnel a kapcsolatot.').'</div>',
                    ];
                } else {
                    return [
                        'succes' => 0,
                        'content' => '<div class="alert alert-danger fade in alert-dismissable">'.Yii::t('app','Hiba történt az üzenet küldése közben. Kérjük, próbálja meg később.').'</div>',
                    ];
                }
            } else {
                $model->product_id=Yii::$app->request->get('id', 0);
                return $this->renderAjax('_enquire', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionUploadinfo()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";

        $agrreform = new \yii\base\DynamicModel([
            'agree'
        ]);

        $agrreform->addRule('agree', 'required', ['requiredValue' => 1, 'message' => Yii::t('app','El kell fogadnod a feltölési feltételeket.')])->validate();

        if ($agrreform->load(Yii::$app->request->post())) {
            if($agrreform->agree==1)
            {
                $loguser=Usermodule::getLogineduser();
                $loguser->agree_upload_info=1;
                $loguser->save(false);

                return $this->redirect(['create']);
            }
        }

        return $this->render('uploadinfo');
    }

    public function actionExpireproducts()
    {
        $products=Products::find()->where('end_date<:date AND expire_noti=0',[':date'=>date('Y-m-d',strtotime('+2 week')).' 00:00:00'])->groupBy('user_id')->all();
        foreach($products as $product){
            $expriceproducts=Products::find()->where('end_date<:date AND user_id=:uid AND expire_noti=0',[':uid'=>$product->user_id,':date'=>date('Y-m-d',strtotime('+2 week')).' 00:00:00'])->all();
            $exproducts=[];
            foreach($expriceproducts as $expriceproduct)
            {
                $exproducts[]=Html::a($expriceproduct->name.' ('.$expriceproduct->end_date.')',$expriceproduct->url);
                $expriceproduct->updateCounters(['expire_noti' => 1]);
            }
            $exproducts=implode('<br/>',$exproducts);
            $mailTemplate = MailTemplates::getTemplate(7,$product->user->lang_code);
            $body = str_replace(['[username]', '[products]'], [$product->user->username, $exproducts], $mailTemplate);
            extra::sendMail($product->user->notificationemail, Yii::t('app', 'Lejáró termék'),$body);
            //Yii::$app->extra->e($body);
        }
    }

    public function actionPdf($id)
    {
            //$this->layout = "@app/themes/mandelan/layouts/filters";
            $this->layout = "@app/themes/mandelan/layouts/main";
            $model = $this->findModel($id);
            if(!empty($model)) {
                $pdf = Yii::$app->pdf;
                $template = '<h1>'.$model->name.'</h1><br/>';
                $template .= Html::img($model->thumb).'<br/><br/>';
                $template .= $model->intro.'<br/>';
                $template .= $model->description.'<br/>';
                $template .= $model->other_info.'<br/>';
                $services=Services::getServicesbyids($model->serviceslist);
                    if(count($services)>0) {
                        $template .= Yii::t('app','Szolgáltatások').'<ul>';
                        foreach ($services as $service){
                            $template .= '<li>'.$service->name.'</li>';
                        }
                        $template .= '</ul>';
                    }
                $mpdf = $pdf->api;
                $mpdf->WriteHtml($template);
                $fname=time().'.pdf';
                echo $mpdf->Output($fname, 'D');
            }
            Yii::$app->end();
    }

    public function actionSearch()
    {
        //$this->layout = "@app/themes/mandelan/layouts/filters";
	$this->layout = "@app/themes/mandelan/layouts/main";

        $filter=[]; $city=[]; $country=[];
        $key=Yii::$app->request->get('searchkey','0');
        if($key!='0') {
        $filter['search']=$key;
            $prodids=[]; $prodidscountry=[];
            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $cities=ArrayHelper::map(CitydescriptionTranslate::find()->where('`title` LIKE "%'.$key.'%" AND `lang_code`="'.Yii::$app->language.'"')->all(), 'citydescription_id', 'citydescription_id');
                $countries=ArrayHelper::map(Countriestranslate::find()->where('`country_name` LIKE "%'.$key.'%" AND `lang_code`="'.Yii::$app->language.'"')->all(), 'country_id', 'country_id');
            } else {
                $cities=ArrayHelper::map(Citydescription::find()->where('`title` LIKE "%'.$key.'%"')->all(), 'id', 'id');
                $countries=ArrayHelper::map(Countries::find()->where('`country_name` LIKE "%'.$key.'%"')->all(), 'id', 'id');
            }
            if(!empty($cities)) {
                $prodids=ArrayHelper::map(Productscities::find()->where(['IN','city_id',$cities])->all(), 'product_id', 'product_id');
            }
            if(!empty($countries)) {
                $prodidscountry=ArrayHelper::map(Productscountires::find()->where(['IN','country_id',$cities])->all(), 'product_id', 'product_id');

            }
            if(!empty($prodids) || !empty($prodidscountry))
                $filter['prodids']= ArrayHelper::merge($prodids, $prodidscountry);


            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $city=CitydescriptionTranslate::find()->where('`title` LIKE "%'.$key.'%" AND `lang_code`="'.Yii::$app->language.'"')->one();
                $country=Countriestranslate::find()->where('`country_name` LIKE "%'.$key.'%" AND `lang_code`="'.Yii::$app->language.'"')->one();
            } else {
                $city=Citydescription::find()->where('`title` LIKE "%'.$key.'%"')->one();
                $country=Countries::find()->where('`country_name` LIKE "%'.$key.'%"')->one();
            }

        }

        $searchModel = new ProductsSearch(
            $filter
        );

        $searchModel->status=Products::STATUS_ACTIVE;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => 'ASC']];

        if ($dataProvider->totalCount > 0) {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'city' => $city,
                'country' => $country,
            ]);
        } else {
            $filter=[];
            $key=Yii::$app->request->get('searchkey','0');
            if($key!='0') {
                $filter['search']=$key;
                if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                    $cities=ArrayHelper::map(CitydescriptionTranslate::find()->where('`title` LIKE "%'.$key.'%" AND `lang_code`="'.Yii::$app->language.'"')->all(), 'citydescription_id', 'citydescription_id');
                } else {
                    $cities=ArrayHelper::map(Citydescription::find()->where('`title` LIKE "%'.$key.'%"')->all(), 'id', 'id');
                }
                if(!empty($cities))
                    $filter['citylist']=$cities;
            }
            $searchModel = new CitydescriptionSearch(
                $filter
            );

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

            return $this->render('cities', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'city' => $city,
                'country' => $country,
            ]);
        }
    }

    public function actionIndex()
    {
        //$this->layout = "@app/themes/mandelan/layouts/filters";
	$this->layout = "@app/themes/mandelan/layouts/main";

        $filter=[]; $city=[]; $country=[];
        //Yii::$app->extra->e(Yii::$app->request->get());
        foreach (Yii::$app->request->get() as $key=>$get)
        {
            if(($key!='page' && $key!='per-page') && ($get!='0' && $get!='all')) $filter[$key]=$get;
        }

        if(isset($filter['catlist']))$filter['catlist']=explode('-',$filter['catlist']);

        //// város és ország leírások keresése
        if(!empty($filter['city'])) {
            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $city=CitydescriptionTranslate::find()->where('`title` LIKE "%'.$filter['city'].'%" AND `lang_code`="'.Yii::$app->language.'"')->one();
            } else {
                $city=Citydescription::find()->where('`title` LIKE "%'.$filter['city'].'%"')->one();
            }
        }
        if(!empty($filter['country'])) {
            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $country=Countriestranslate::find()->where('`country_name` LIKE "%'.$filter['country'].'%" AND `lang_code`="'.Yii::$app->language.'"')->one();
            } else {
                $country=Countries::find()->where('`country_name` LIKE "%'.$filter['country'].'%"')->one();
            }
        }

        $searchModel = new ProductsSearch(
            //Yii::$app->request->post('DynamicModel')
            $filter
        );

        $searchModel->status=Products::STATUS_ACTIVE;
        $searchModel->marketplace=Products::STATUS_INACTIVE;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'city' => $city,
            'country' => $country,
        ]);
    }

    public function actionMarketplace()
    {
        //$this->layout = "@app/themes/mandelan/layouts/filters";
	$this->layout = "@app/themes/mandelan/layouts/main";

        $filter=[];

        foreach (Yii::$app->request->get() as $key=>$get)
        {
            if(($key!='page' && $key!='per-page') && ($get!='0' && $get!='all')) $filter[$key]=$get;
        }

        if(isset($filter['catlist']))$filter['catlist']=explode('-',$filter['catlist']);

        $searchModel = new ProductsSearch(
            //Yii::$app->request->post('DynamicModel')
            $filter
        );

        $searchModel->status=Products::STATUS_ACTIVE;
        $searchModel->marketplace=Products::STATUS_ACTIVE;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('marketplace', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new ProductsadminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $uId = Yii::$app->request->post('editableKey');

            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['Products']);

            $model=Products::findOne($uId);

            if (isset($posted['partnercomment']) && !empty($model)) {
                Users::updateAll([
                    'comment' => $posted['partnercomment'],
                ], 'id='.$model->user_id);


                $output = $posted['partnercomment'];

            $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        //Yii::$app->extra->e($searchModel);
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyproducts()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";

        $searchModel = new ProductsSearch();
        if(Yii::$app->getModule('users')->isPartners())
        {
            $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);
            $searchModel->user_id=$partner->user_id;
        } else {
            $searchModel->user_id=Yii::$app->user->id;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=15;

        return $this->render('myproducts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        //$this->layout = "@app/themes/mandelan/layouts/filters";
	$this->layout = "@app/themes/mandelan/layouts/main";
        $model = $this->findModel($id);

        if(!ArrayHelper::isIn($model->id, $model->userproductsids) && $model->status==Products::STATUS_INACTIVE && !Usermodule::isAdmin())
            throw new \yii\web\NotFoundHttpException();

        Meta::renderByparams(
        [
            'title' => extra::getIntro($model->name,60),
            'description' => extra::getIntro($model->intro,150),
            'og_image' => $model->ogthumb,
            'og_url' => $model->url,
        ]);

        /*Yii::$app->meta->setMeta([
            'title' => extra::getIntro($model->name,60),
            'description' => extra::getIntro($model->intro,150),
        ]);
        Yii::$app->view->registerMetaTag(['name' => 'og:url', 'content' => \yii\helpers\Url::to($model->url) ], 'og:url');
        Yii::$app->view->registerMetaTag(['name' => 'og:image', 'content' => $model->ogthumb ], 'og:image');*/

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    public function actionCreate()
    {
        if(Yii::$app->getModule('users')->isAdmin())
            $this->redirectToAdmin();

        if(!extra::isAdminpage()) $this->layout = "@app/themes/mandelan/layouts/profile";

        /*$loguser=Usermodule::getLogineduser();
        if($loguser->agree_upload_info==0 && !Yii::$app->getModule('users')->isAdmin()) {
            return $this->redirect(['uploadinfo']);
        }*/

        $model = new Products();
        $model->start_date=date('Y-m-d',time());
        $user_id=Yii::$app->user->id;
        if(Yii::$app->getModule('users')->isPartners())
        {
            $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);
            $user_id=$partner->user_id;
        }
        $model->user_id=$user_id;
        $model->creator_id=Yii::$app->user->id;

        $modelTranslations = [];
        /*foreach (Language::getLanguages() as $language) {
            if($language->language_id!=Yii::$app->sourceLanguage) {
                $langId=$language->language_id;
        	$translation = new Productstranslate;
		$translation->lang_code = $langId;
                $modelTranslations[] = $translation;
            }
        }*/
        $modelPrices = $model->prices;
        $modelTimes = $model->times;

        if ($model->load(Yii::$app->request->post())) {

            $pricesoldIDs = ArrayHelper::map($modelPrices, 'id', 'id');
            $timesoldIDs = ArrayHelper::map($modelTimes, 'id', 'id');

            $modelPrices = Model::createMultiple(Productsprice::classname(), $modelPrices);
            $modelTimes = Model::createMultiple(ProductsTime::classname(), $modelTimes);

            Model::loadMultiple($modelPrices, Yii::$app->request->post());
            Model::loadMultiple($modelTimes, Yii::$app->request->post());

            $deletedpricesIDs = array_diff($pricesoldIDs, array_filter(ArrayHelper::map($modelPrices, 'id', 'id')));
            $deletedtimesIDs = array_diff($timesoldIDs, array_filter(ArrayHelper::map($modelPrices, 'id', 'id')));

            $image = UploadedFile::getInstance($model, 'image');
            if(!empty($image)){
                $model->image = extra::generateFilename($image->name);
                $path = WEB_ROOT.'/'.Yii::$app->params['productsPictures'] . $model->image;
            }

            //$model->blockoutsdates=Yii::$app->request->post('blockoutsdates-products-blockoutsdates');

             // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelPrices),
                    ActiveForm::validateMultiple($modelTimes),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPrices) && $valid;
            $valid = Model::validateMultiple($modelTimes) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $minprice=0;
                    foreach ($modelPrices as $modelPrice) {
                        if($minprice==0 || $minprice>$modelPrice->price) $minprice=$modelPrice->price;
                    }
                    $model->price=$minprice;
                    if ($flag = $model->save(false)) {
                        if (!empty($image)) $image->saveAs($path);
                        if (! empty($deletedpricesIDs)) {
                            Productsprice::deleteAll(['id' => $deletedpricesIDs]);
                        }
                        if (! empty($deletedtimesIDs)) {
                            Productsprice::deleteAll(['id' => $deletedtimesIDs]);
                        }
                        foreach ($modelPrices as $modelPrice) {
                            $modelPrice->product_id = $model->id;
                            if (! ($flag = $modelPrice->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelTimes as $modelTime) {
                            $modelTime->product_id = $model->id;
                            if (! ($flag = $modelTime->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        //$model->price=$model->minimalprice->price;
                        //$model->save(false);
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

                $modelTranslationsIDs = ArrayHelper::map($modelTranslations, 'id', 'id');
                //$modelTranslations = Model::createMultiple(StaticpagesTranslate::classname(), $modelTranslations);
                Model::loadMultiple($modelTranslations, Yii::$app->request->post());

                foreach ($modelTranslations as $modelTranslation) {
                    if(!empty($modelTranslation->name)) {
                        $modelTranslation->product_id = $model->id;
                        $modelTranslation->save();
                    }
                }

                Yii::$app->session->setFlash('success', Yii::t('app','A termék létrehozva.'));
                return $this->redirect(['update', 'id' => $model->id]);

        } else {

            if(!Yii::$app->getModule('users')->isAdmin()) $model->status=Products::STATUS_INACTIVE;

            $model->lang_code=Yii::$app->language;

            return $this->render('create', [
                'model' => $model,
                'modelTranslations' => $modelTranslations,
                'modelPrices' => (empty($modelPrices)) ? [new Productsprice] : $modelPrices,
                'modelTimes' => (empty($modelTimes)) ? [new ProductsTime] : $modelTimes
            ]);
        }
    }

    public function actionUpdate($id)
    {
        if(Yii::$app->getModule('users')->isAdmin())
            $this->redirectToAdmin();

        if(!extra::isAdminpage()) $this->layout = "@app/themes/mandelan/layouts/profile";
        $model = $this->findModel($id);

        if($model->end_date=='0000-00-00') $model->end_date='';

        $modelPrices = $model->prices;
        $modelTimes = $model->times;

        $changed=[];
        if(!Yii::$app->getModule('users')->isAdmin()) {
            $pricesold=Json::encode($model->prices);
            $timeold=Json::encode($model->times);
            $translationsold=Json::encode($model->translations);
        }

        foreach ($modelPrices as $modelPrice)
        {
            foreach (Language::getLanguages() as $language) {
                if($language->language_id!=$model->lang_code) {
                    $langId=$language->language_id;
                    $translation = Productspricetranslate::findOne(['product_price_id'=>$modelPrice->id, 'lang_code'=>$langId]);

                    $modelPrice->nametranslate[$langId]=(!empty($translation))?$translation->name:'';
                    $modelPrice->descriptiontranslate[$langId]=(!empty($translation))?$translation->description:'';
                }
            }
        }

        $modelTranslations = $model->translations;
        foreach (Language::getLanguages() as $language) {
            //if($language->language_id!=Yii::$app->sourceLanguage) {
            if($language->language_id!=$model->lang_code) {
                $langId=$language->language_id;
        	$translation = Productstranslate::findOne(['product_id'=>$model->id, 'lang_code'=>$langId]);
        	if(empty($translation)) {
        		$translation = new Productstranslate;
                        $translation->product_id = $model->id;
			$translation->lang_code = $langId;
                        $modelTranslations[] = $translation;
        	}
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            //extra::e($model);
            $pricesoldIDs = ArrayHelper::map($modelPrices, 'id', 'id');
            $timesoldIDs = ArrayHelper::map($modelTimes, 'id', 'id');

            $modelPrices = Model::createMultiple(Productsprice::classname(), $modelPrices);
            $modelTimes = Model::createMultiple(ProductsTime::classname(), $modelTimes);

            Model::loadMultiple($modelPrices, Yii::$app->request->post());
            Model::loadMultiple($modelTimes, Yii::$app->request->post());

            $deletedpricesIDs = array_diff($pricesoldIDs, array_filter(ArrayHelper::map($modelPrices, 'id', 'id')));
            $deletedtimesIDs = array_diff($timesoldIDs, array_filter(ArrayHelper::map($modelTimes, 'id', 'id')));

            $image = UploadedFile::getInstance($model, 'image');
            if(!empty($image)){
                $model->image = extra::generateFilename($image->name);
                $path = WEB_ROOT.'/'.Yii::$app->params['productsPictures'] . $model->image;
                if($model->OldAttributes['image']!='' && file_exists(WEB_ROOT.'/'.Yii::$app->params['productsPictures'] . $model->OldAttributes['image']))unlink(WEB_ROOT.'/'.Yii::$app->params['productsPictures'] . $model->OldAttributes['image']);
            } else {
                $model->image=$model->OldAttributes['image'];
            }
            //Yii::$app->extra->e(Yii::$app->request->post());
            //$model->blockoutsdates=Yii::$app->request->post('blockoutsdates-products-blockoutsdates');

             // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelPrices),
                    ActiveForm::validateMultiple($modelTimes),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPrices) && $valid;
            $valid = Model::validateMultiple($modelTimes) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (!empty($image)) $image->saveAs($path);
                        if (! empty($deletedpricesIDs)) {
                            Productsprice::deleteAll(['id' => $deletedpricesIDs]);
                        }
                        if (! empty($deletedtimesIDs)) {
                            ProductsTime::deleteAll(['id' => $deletedtimesIDs]);
                        }
                        foreach ($modelTimes as $modelTime) {
                            $modelTime->product_id = $model->id;
                            if (! ($flag = $modelTime->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelPrices as $modelPrice) {
                            $modelPrice->product_id = $model->id;

                            if (! ($flag = $modelPrice->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            ///árak fordítása
                            foreach (Language::getLanguages() as $language) {
                                if($language->language_id!=$model->lang_code) {
                                    $langId=$language->language_id;
                                    $translation = Productspricetranslate::findOne(['product_price_id'=>$modelPrice->id, 'lang_code'=>$langId]);
                                    if(empty($translation) && ($modelPrice->nametranslate[$langId]!='' || $modelPrice->descriptiontranslate[$langId]!='')) {
                                        $translation = new Productspricetranslate;
                                        $translation->product_price_id=$modelPrice->id;
                                        $translation->lang_code=$langId;
                                        $translation->name=$modelPrice->nametranslate[$langId];
                                        $translation->description=$modelPrice->descriptiontranslate[$langId];
                                        $translation->save(false);
                                    } else {
                                        if($modelPrice->nametranslate[$langId]!='' || $modelPrice->descriptiontranslate[$langId]!='') {
                                            $translation->name=$modelPrice->nametranslate[$langId];
                                            $translation->description=$modelPrice->descriptiontranslate[$langId];
                                            $translation->save(false);
                                        } else {
                                            Productspricetranslate::deleteAll(['product_price_id'=>$modelPrice->id, 'lang_code'=>$langId]);
                                        }
                                    }
                                }
                            }
                        }
                        //$model->price=$model->minimalpricetosave; //az alapár megadása (legolcsóbb jegy)
                        //$model->save(false);
                        Products::updateAll(['price'=>$model->minimalpricetosave], 'id='.$model->id);
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            $modelTranslationsIDs = ArrayHelper::map($modelTranslations, 'id', 'id');

            Model::loadMultiple($modelTranslations, Yii::$app->request->post());

            foreach ($modelTranslations as $modelTranslation) {
                if(!$modelTranslation->isNewRecord && empty($modelTranslation->name))
                    $modelTranslation->delete();
                elseif(!empty($modelTranslation->name))
                    $modelTranslation->save();
            }

            if(!Yii::$app->getModule('users')->isAdmin()) {
                $changed=[];

                $model->findOne($model->id);

                $changed=Json::decode($model->changed);

                $pricesnew=Json::encode($model->prices);
                $timenew=Json::encode($model->times);
                $translationsnew=Json::encode($model->translations);

                if($pricesnew!=$pricesold) $changed[]='Árak';
                if($timenew!=$timeold) $changed[]='Időpontok';
                if($translationsnew!=$translationsold) $changed[]='Fordítás';

                Products::updateAll([
                    'changed' => Json::encode($changed),
                ], 'id='.$model->id);

                $model->findOne($model->id);

                $body='<h3>Teméket módosítottak</h3><br/>';
                $body.='Név: '.$model->name.'<br/>';
                $body.='Módosította: '.$model->user->username.' ('.$model->user->email.')<br/>';
                $body.='Időpont: '.date('Y-m-d H:i:s', time()).'<br/><br/>';
                $body.=(!empty($changed))?'<b>Változások: </b><br/>'.implode(',', $changed).'<br/><br/>':'';

                extra::sendMail(Yii::$app->params['adminEmail'], Yii::t('app', 'Terméket módosítottak'),$body);
                extra::sendMail(Yii::$app->params['adminEmailNoti'], Yii::t('app', 'Terméket módosítottak'),$body);
            }

            //$model->save();
            //return $this->redirect('admin');
            Yii::$app->session->setFlash('success', Yii::t('app','A termék módosítva.'));

            /*return $this->render('update', [
                'model' => $model,
                'modelTranslations' => $modelTranslations,
                'modelPrices' => (empty($modelPrices)) ? [new Productsprice] : $modelPrices,
                'modelTimes' => (empty($modelTimes)) ? [new ProductsTime] : $modelTimes
            ]);*/
        } //else {

        $blockouts=$model->blockouts;
        if(!empty($blockouts)) { $model->blockoutsdates=$blockouts->dates; }

            return $this->render('update', [
                'model' => $model,
                'modelTranslations' => $modelTranslations,
                'modelPrices' => (empty($modelPrices)) ? [new Productsprice] : $modelPrices,
                'modelTimes' => (empty($modelTimes)) ? [new ProductsTime] : $modelTimes
            ]);
        //}
    }

    public function actionDelete($id)
    {
        if(Yii::$app->getModule('users')->isAdmin())
            $this->redirectToAdmin();

        if(!extra::isAdminpage() && !Yii::$app->getModule('users')->isAdmin()) $this->layout = "@app/themes/mandelan/layouts/profile";

        Productstranslate::deleteAll(['product_id'=>$id]);

        $this->findModel($id)->delete();

        if(!extra::isAdminpage() && (Yii::$app->getModule('users')->isPartner() || Yii::$app->getModule('users')->isPartners()))
            return $this->redirect(['myproducts']);
        else
            return $this->redirect(['admin']);
    }

    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions()
    {
        return [
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                // mappings between type names and model classes (should be the same as in behaviour)
                'types' => [
                    'products' => Products::className()
                ]
            ],
        ];
    }
}