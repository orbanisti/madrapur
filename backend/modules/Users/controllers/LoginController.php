<?phpbackend\backend\backend\backend\backend\backend\backend\backend\

namespace app\modules\Users\controllers;

use Yii;
use app\modules\Users\models\forms\LoginForm;
use app\modules\Users\models\Loginhistory;
use app\modules\Users\Module as Usermodule;
use app\components\extra;
use app\components\Controller;
use app\modules\Users\models\Users;
use app\modules\Users\models\Profile;
//use yii\web\Controller;

class LoginController extends Controller
{

    public $defaultAction = 'login';

    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(Usermodule::$profileUrl);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $history = new Loginhistory;
            $history->userid=$model->getUser()->id;
            $history->ip=extra::getClientip();
            $history->browser=$_SERVER['HTTP_USER_AGENT'];
            $history->save(false);

            return $this->redirect(Usermodule::$returnUrl);
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }

    public function actionLoginfb()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(Usermodule::$profileUrl);
        }

        $social = Yii::$app->getModule('social');

        $fb = $social->getFb(); // gets facebook object based on module settings

        try {
            $helper = $fb->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {

            // There was an error communicating with Graph
            return $this->render('validate-fb', [
                'out' => '<div class="alert alert-danger">' . $e->getMessage() . '</div>'
            ]);
        }

        if (isset($accessToken)) { // you got a valid facebook authorization token
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
            $fbuser=$response->getGraphUser();

            $user=Users::findOne(['fb_id'=>$fbuser['id']]);

            if(empty($user)) {
            $userem=Users::findOne(['email'=>$fbuser['email']]);
            if(!empty($userem)) {
                return $this->render('validate-fb', [
                    'out' => Yii::t('app','Ezzel az email címmel már regisztráltak')
                ]);
            }

            $user = new Users;
            $user->email=$fbuser['email'];
            $user->fb_id=$fbuser['id'];
            $username=extra::stringToUrl($fbuser['name']);
            $usern=Users::findOne(['username'=>$username]);

            if(!empty($usern)) $username.='-'.$fbuser['id'];

            $user->username=$username;
            $user->hashcode=Usermodule::encrypting(microtime().$fbuser['email']);
            $pass=microtime().$fbuser['email'].time();
            $user->password=Usermodule::encrypting($pass);

            if(Yii::$app->request->cookies->has(Yii::$app->params['langCookiename'])) {
                Yii::$app->language = Yii::$app->request->cookies->getValue(Yii::$app->params['langCookiename']);
            }

            $user->lang_code=Yii::$app->language;
            $user->status=Usermodule::STATUS_ACTIVE;
            $user->type=Usermodule::TYPE_PERSON;
            $user->save(false);

            $profile=new Profile;
            $profile->userid=$user->id;
            $profile->save(false);

                Yii::$app->user->login($user, 0);

                return $this->redirect(Usermodule::$returnUrl);

            } else {
                Yii::$app->user->login($user, 0);
                return $this->redirect(Usermodule::$returnUrl);
            }

        } elseif ($helper->getError()) {
            // the user denied the request
            // You could log this data . . .
            return $this->render('validate-fb', [
                'out' => '<legend>Validation Log</legend><pre>' .
                '<b>Error:</b>' . print_r($helper->getError(), true) .
                '<b>Error Code:</b>' . print_r($helper->getErrorCode(), true) .
                '<b>Error Reason:</b>' . print_r($helper->getErrorReason(), true) .
                '<b>Error Description:</b>' . print_r($helper->getErrorDescription(), true) .
                '</pre>'
            ]);
        }
        return $this->render('validate-fb', [
            'out' => '<div class="alert alert-warning"><h4>Oops! Nothing much to process here.</h4></div>'
        ]);
    }

}