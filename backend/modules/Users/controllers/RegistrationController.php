<?phpbackend\backend\backend\backend\backend\backend\backend\backend\

namespace app\modules\Users\controllers;

use Yii;
use yii\helpers\Html;
use app\modules\Users\models\forms\RegistrationForm;
use app\modules\Users\models\Users;
use app\modules\Users\Module as Usermodule;
use app\modules\Mailtemplates\models\MailTemplates;
use app\components\extra;
use app\modules\Users\models\Loginhistory;
use app\components\Controller;
//use yii\web\Controller;



class RegistrationController extends Controller

{

    

    public $defaultAction = 'registration';

    

    public function actionRegistration()

    {

        if(!Yii::$app->user->isGuest)

            return $this->redirect(Usermodule::$returnUrl);

        if (Yii::$app->request->isAjax) {

            return $this->renderAjax('registration');

        }

        

        return false;

    }

    

    public function actionUserregistration()

    {

        if(!Yii::$app->user->isGuest)

            return $this->redirect(Usermodule::$returnUrl);

            

        $model = new RegistrationForm();



        if ($model->load(Yii::$app->request->post()) && $model->registration(Usermodule::TYPE_PERSON)) {

            Yii::$app->session->setFlash('success', Yii::t('app','Sikeres regisztráció.'));

            

            $activation_url = Yii::$app->getUrlManager()->createAbsoluteUrl(['/users/activation/activation',"activkey" => $model->hashcode, "email" => $model->email]);

            $mailTemplate = MailTemplates::getTemplate(1,Yii::$app->language);

            $activation_link = Html::a($activation_url, $activation_url);

            $name = $model->username;

            $body = str_replace(['[link]', '[username]'], [$activation_link, $name], $mailTemplate);



            extra::sendMail($model->email, Yii::t('app', 'Regisztráció megerősítése'),$body);

            

            Yii::$app->user->login(Users::findOne($model->id),0);

            

            $history = new Loginhistory;

            $history->userid=$model->id;

            $history->ip=extra::getClientip();

            $history->browser=$_SERVER['HTTP_USER_AGENT'];

            $history->save(false);

            

            return $this->redirect(Usermodule::$returnUrl);

        }

        

        return $this->render('userregistration', [

            'model' => $model,

        ]);

    }

    

    public function actionPartnerregistration()

    {

        if(!Yii::$app->user->isGuest)

            return $this->redirect(Usermodule::$returnUrl);

            

        $model = new RegistrationForm();

        $model->scenario = 'partnerregistration';

        

        $message='';

        $title='';



        if ($model->load(Yii::$app->request->post()) && $model->registration(Usermodule::TYPE_PARTNER)) {

            Yii::$app->session->setFlash('success', Yii::t('app','Sikeres regisztráció.'));

            

            $activation_url = Yii::$app->getUrlManager()->createAbsoluteUrl(['/users/activation/activation',"activkey" => $model->hashcode, "email" => $model->email]);

            $mailTemplate = MailTemplates::getTemplate(3,Yii::$app->language);

            $activation_link = Html::a($activation_url, $activation_url);

            $name = $model->username;

            $body = str_replace(['[link]', '[username]'], [$activation_link, $name], $mailTemplate);



            extra::sendMail($model->email, Yii::t('app', 'Sikeres regisztráció'),$body);

            

            /*$title=Yii::t('app', 'Sikeres regisztráció');

            $message=Yii::t('app', 'Regisztrációja inaktív, hamarosan felvesszük önnel a kapcsolatot.');

            

            return $this->render('/users/message', [

                'message' => $message,

                'title' => $title,

            ]);*/

            

            Yii::$app->user->login(Users::findOne($model->id),0);

            

            $history = new Loginhistory;

            $history->userid=$model->id;

            $history->ip=extra::getClientip();

            $history->browser=$_SERVER['HTTP_USER_AGENT'];

            $history->save(false);

            

            return $this->redirect(Usermodule::$returnUrl);

        }

        

        return $this->render('partnerregistration', [

            'model' => $model,

        ]);

    }



}

