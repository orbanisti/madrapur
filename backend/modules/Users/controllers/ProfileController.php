<?phpbackend\backend\backend\backend\backend\backend\backend\backend\backend\backend\

namespace app\modules\Users\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\Users\models\Users;
use app\modules\Users\models\forms\ChangepasswordForm;
use app\modules\Users\Module as Usermodule;
use zxbodya\yii2\imageAttachment\ImageAttachmentAction;
use app\components\Controller;
use yii\web\UploadedFile;
use app\components\extra;
use app\modules\Users\models\Usertermsconditions;
use app\modules\Users\models\Usertermsconditionstranslate;
use app\base\Model;
use lajax\translatemanager\models\Language;

class ProfileController extends Controller
{

    public $defaultAction = 'profile';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['profile'],
                'rules' => [
                    [
                        'actions' => ['termsconditions','profile','changepassword','changeemail','edit','imgAttachApi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['termsconditionsuser'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->getModule('users')->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'imgAttachApi' => [
                'class' => ImageAttachmentAction::className(),
                // mappings between type names and model classes (should be the same as in behaviour)
                'types' => [
                    'profile' => \app\modules\Users\models\Profile::className()
                ]
            ],
        ];
    }
    
    public function actionTermsconditions()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";
        
        $id=Yii::$app->user->id;
        $user=Users::findOne($id);
        
        $terms=$user->termsconditions;
        if(empty($terms)) {
            $terms = new Usertermsconditions;
            $terms->user_id=$user->id;
            $terms->lang_code=$user->lang_code;
        }
        
        $termsTranslations = $terms->translations;
        foreach (Language::getLanguages() as $language) {
            if($language->language_id!=$terms->lang_code) {
                $langId=$language->language_id;
        	$translation = Usertermsconditionstranslate::findOne(['user_tc'=>$terms->id, 'lang_code'=>$langId]);
        	if(empty($translation)) {
        		$translation = new Usertermsconditionstranslate;
                        $translation->user_tc = $terms->id;
			$translation->lang_code = $langId;
                        $termsTranslations[] = $translation;
        	}
            }
        }
        
        if ($terms->load(Yii::$app->request->post())) {
            $terms->save();
                    
            Model::loadMultiple($termsTranslations, Yii::$app->request->post());

            foreach ($termsTranslations as $modelTranslation) {
                if(!$modelTranslation->isNewRecord && empty($modelTranslation->content))
                    $modelTranslation->delete();
                elseif(!empty($modelTranslation->content)) {
                    $modelTranslation->user_tc=$terms->id;
                    $modelTranslation->save();
                }
            }
        }
        
        return $this->render('termsconditions', [
            'terms' => $terms,
            'termsTranslations' => $termsTranslations
        ]);
    }
    
    public function actionTermsconditionsuser($id)
    {
        //$this->layout = "@app/themes/mandelan/layouts/profile";
        
        $user=Users::findOne($id);
        
        $terms=$user->termsconditions;
        if(empty($terms)) {
            $terms = new Usertermsconditions;
            $terms->user_id=$user->id;
            $terms->lang_code=$user->lang_code;
        }
        
        $termsTranslations = $terms->translations;
        foreach (Language::getLanguages() as $language) {
            if($language->language_id!=$terms->lang_code) {
                $langId=$language->language_id;
        	$translation = Usertermsconditionstranslate::findOne(['user_tc'=>$terms->id, 'lang_code'=>$langId]);
        	if(empty($translation)) {
        		$translation = new Usertermsconditionstranslate;
                        $translation->user_tc = $terms->id;
			$translation->lang_code = $langId;
                        $termsTranslations[] = $translation;
        	}
            }
        }
        
        if ($terms->load(Yii::$app->request->post())) {
            $terms->save();
                    
            Model::loadMultiple($termsTranslations, Yii::$app->request->post());

            foreach ($termsTranslations as $modelTranslation) {
                if(!$modelTranslation->isNewRecord && empty($modelTranslation->content))
                    $modelTranslation->delete();
                elseif(!empty($modelTranslation->content)) {
                    $modelTranslation->user_tc=$terms->id;
                    $modelTranslation->save();
                }
            }
        }
        
        return $this->render('termsconditions_user', [
            'user' => $user,
            'terms' => $terms,
            'termsTranslations' => $termsTranslations
        ]);
    }

    public function actionEdit()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";
        
        $id=Yii::$app->user->id;
        $user=Users::findOne($id);
        
        $model=$user->profile;
        
        if ($model->load(Yii::$app->request->post())) {
           
            $image = UploadedFile::getInstance($model, 'logo');
            
            if(!empty($image)){
                $model->logo = extra::generateFilename($image->name);
                $path = WEB_ROOT.Yii::$app->params['logoPictures'] . $model->logo;
                if($model->OldAttributes['logo']!='' && file_exists(WEB_ROOT.Yii::$app->params['logoPictures'] . $model->OldAttributes['logo']))unlink(WEB_ROOT.Yii::$app->params['logoPictures'] . $model->OldAttributes['logo']);
            } else {
                $model->logo=$model->OldAttributes['logo'];
            }

            if($model->save(false)){
                if(!empty($image)) $image->saveAs($path);
            }

        }

        return $this->render('edit', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";
        
        $id=Yii::$app->user->id;
        $user=Users::findOne($id);
        if($user->type==Usermodule::TYPE_PARTNER) {
            return $this->render('partnerprofile', [
                'model' => $user,
            ]);
        } else {
            return $this->render('profile', [
                'model' => $user,
            ]);
        }
    }
    
    public function actionChangepassword()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";
        $model = new ChangepasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->changepassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','A jelszót sikeresen megváltoztattad.'));
            return $this->refresh();
        }

        return $this->render('changepassword', [
            'model' => $model,
        ]);
    }
    
    public function actionChangeemail()
    {
        $this->layout = "@app/themes/mandelan/layouts/profile";
       
        $model = Users::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app','Az email címed sikeresen megváltoztattad.'));
            return $this->refresh();
        }
        
        return $this->render('changeemail', [
            'model' => $model,
        ]);
    }

}