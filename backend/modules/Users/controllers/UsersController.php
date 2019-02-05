<?phpbackend\backend\backend\backend\backend\backend\backend\

namespace app\modules\Users\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\Users\models\Users;
use app\modules\Users\models\search\UsersSearch;
use app\modules\Users\models\search\UsersuserSearch;
use app\modules\Users\models\search\UserspartnerSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\modules\Users\Module as Usermodule;

class UsersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['partners', 'users', 'index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->getModule('users')->isAdmin();
                        }
                    ],
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

    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPartners()
    {

        $searchModel = new UserspartnerSearch();
        $filters=Yii::$app->request->queryParams;
        $filters['UserspartnerSearch']['type']=Usermodule::TYPE_PARTNER;

        $dataProvider = $searchModel->search($filters);

        if (Yii::$app->request->post('hasEditable')) {
            $uId = Yii::$app->request->post('editableKey');
            $model = Users::findOne($uId);

            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['Users']);
            $post = ['Users' => $posted];

            if ($model->load($post)) {
            $model->save(false);

            $output = '';

            if (isset($posted['comment'])) {
                $output = $model->comment;
            }

            $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('partners', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionUsers()
    {
        $searchModel = new UsersuserSearch();
        $filters=Yii::$app->request->queryParams;
        $filters['UsersSearch']['type']=Usermodule::TYPE_PARTNER;
        $dataProvider = $searchModel->search($filters);

        return $this->render('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {

        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$profile = $model->profile;

        if ($model->load(Yii::$app->request->post()) /*&& $profile->load(Yii::$app->request->post())*/ && $model->save() /*&& $profile->save()*/) {
            if($model->type==Usermodule::TYPE_PARTNER) {
                return $this->redirect(['partners']);
            }
            return $this->redirect(['users']);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'profile' => $profile
            ]);
        }

    }

    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $type=$model->type;
        $model->delete();

        if($type==Usermodule::TYPE_PARTNER) {
            return $this->redirect(['partners']);
        }

        return $this->redirect(['users']);

    }

    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}