<?php

backend\

namespace app\modules\Users\controllers;
backend\
backend\
backend\
use Yii;

use app\modules\Users\models\Userpartners;

use app\modules\Users\models\UserpartnersSearch;

use app\components\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use yii\helpers\ArrayHelper;



/**

 * UserpartnersController implements the CRUD actions for Userpartners model.

 */

class UserpartnersController extends Controller

{

    public $layout = "@app/themes/mandelan/layouts/profile";

    

    public function behaviors()

    {

        return [

            'access' => [

                'class' => AccessControl::className(),

                'only' => ['profile'],

                'rules' => [

                    [

                        'actions' => ['create','index'],

                        'allow' => true,

                        'roles' => ['@'],

                    ],

                    [

                        'actions' => ['update','delete'],

                        'allow' => true,

                        'roles' => ['@'],

                        'matchCallback' => function ($rule, $action) {

                            if ($this->isUserAuthor()) {

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

    

    protected function isUserAuthor()

    {

        return $this->findModel(Yii::$app->request->get('id'))->user_id == Yii::$app->user->id;

    }



    /**

     * Lists all Userpartners models.

     * @return mixed

     */

    public function actionIndex()

    {

        $searchModel = new UserpartnersSearch();

        $mypartners['UserpartnersSearch']['user_id']=Yii::$app->user->id;

        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,$mypartners));



        return $this->render('index', [

            'searchModel' => $searchModel,

            'dataProvider' => $dataProvider,

        ]);

    }



    /**

     * Displays a single Userpartners model.

     * @param integer $id

     * @return mixed

     */

    public function actionView($id)

    {

        return $this->render('view', [

            'model' => $this->findModel($id),

        ]);

    }



    /**

     * Creates a new Userpartners model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     * @return mixed

     */

    public function actionCreate()

    {

        $model = new Userpartners();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect('index');

        } else {

            return $this->render('create', [

                'model' => $model,

            ]);

        }

    }



    /**

     * Updates an existing Userpartners model.

     * If update is successful, the browser will be redirected to the 'view' page.

     * @param integer $id

     * @return mixed

     */

    public function actionUpdate($id)

    {

        $model = $this->findModel($id);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect('index');

        } else {

            return $this->render('update', [

                'model' => $model,

            ]);

        }

    }



    /**

     * Deletes an existing Userpartners model.

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

     * Finds the Userpartners model based on its primary key value.

     * If the model is not found, a 404 HTTP exception will be thrown.

     * @param integer $id

     * @return Userpartners the loaded model

     * @throws NotFoundHttpException if the model cannot be found

     */

    protected function findModel($id)

    {

        if (($model = Userpartners::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }

    }

}

