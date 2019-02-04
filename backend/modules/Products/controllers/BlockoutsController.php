<?phpnamespace backend\modules\Products



namespace app\modules\Products\controllers;



use Yii;

use app\modules\Products\models\Blockouts;

use app\modules\Products\models\BlockoutsSearch;

//use yii\web\Controller;

use app\components\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use yii\helpers\ArrayHelper;

use app\modules\Products\models\Products;



/**

 * BlockoutsController implements the CRUD actions for Blockouts model.

 */

class BlockoutsController extends Controller

{

    public function behaviors()

    {

        return [

            'access' => [

                'class' => AccessControl::className(),

                'rules' => [

                    [

                        'actions' => ['create','index'],

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

    

    public $layout = "@app/themes/mandelan/layouts/profile";



    protected function isUserAuthor()

    {

        $model = $this->findModel(Yii::$app->request->get('id'));

        if(empty($model)) return false;

        return ArrayHelper::isIn($model->product_id, Products::getUserproductsids());

    }

    

    /**

     * Lists all Blockouts models.

     * @return mixed

     */

    public function actionIndex()
    {
        $searchModel = new BlockoutsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        ///// régi tiltások másolásba a jelölős megoldáshoz
        /*$blockounts=Blockouts::find()->groupBy(['product_id'])->all();
        foreach ($blockounts as $bko)
        {
            $days=[];
            foreach (Blockouts::find()->where(['product_id'=>$bko->product_id])->all() as $blockout)
            {
                if($blockout->start_date==$blockout->end_date)
                {
                    $days[]=$blockout->start_date;
                } else {
                    $days[]=$blockout->start_date;
                    $day=$blockout->start_date;
                    do{
                        //$day=Yii::$app->formatter->asDatetime((strtotime($day)+60*60*24),'php:Y-m-d');
                        $day=Yii::$app->formatter->asDatetime((strtotime("+1 day",strtotime($day))),'php:Y-m-d');
                        $days[]=$day;
                    }while (strtotime($day)<strtotime($blockout->end_date));
                }
            }
            $newbcko = new  Blockouts();
            $newbcko->product_id=$bko->product_id;
            $newbcko->dates=implode(',',$days);
            $newbcko->save(false);
        }*/
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**

     * Creates a new Blockouts model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     * @return mixed

     */

    public function actionCreate()

    {

        $model = new Blockouts();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect('index');

        } else {

            return $this->render('create', [

                'model' => $model,

            ]);

        }

    }



    /**

     * Updates an existing Blockouts model.

     * If update is successful, the browser will be redirected to the 'view' page.

     * @param integer $id

     * @return mixed

     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            $model->dates=Yii::$app->request->post('dates-blockouts-dates');
            
            if($model->save(false))
                return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**

     * Deletes an existing Blockouts model.

     * If deletion is successful, the browser will be redirected to the 'index' page.

     * @param integer $id

     * @return mixed

     */

    public function actionDelete($id)

    {

        $this->findModel($id)->delete();



        return $this->redirect(['index']);

    }



    /**

     * Finds the Blockouts model based on its primary key value.

     * If the model is not found, a 404 HTTP exception will be thrown.

     * @param integer $id

     * @return Blockouts the loaded model

     * @throws NotFoundHttpException if the model cannot be found

     */

    protected function findModel($id)

    {

        if (($model = Blockouts::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }

    }

}

