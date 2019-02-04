<?php





namespace backend\modules\Products\controllers;





use Yii;


use backend\modules\Products\models\Productsopinion;


use backend\modules\Products\models\ProductsopinionSearch;


//use yii\web\Controller;


use backend\components\Controller;


use yii\web\NotFoundHttpException;


use yii\filters\VerbFilter;


use \backend\modules\Products\models\Products;


use yii\filters\AccessControl;


use backend\modules\Users\Module as Usermodule;


use yii\helpers\ArrayHelper;





/**


 * ProductsopinionController implements the CRUD actions for Productsopinion model.


 */


class ProductsopinionController extends Controller


{


    public function behaviors()


    {


        return [


            'access' => [


                'class' => AccessControl::className(),


                'only' => ['profile'],


                'rules' => [


                    [


                        'actions' => ['create','myproductsop'],


                        'allow' => true,


                        'roles' => ['@'],


                    ],


                    [


                        'actions' => ['update','updateinlist','delete'],


                        'allow' => true,


                        'roles' => ['@'],


                        'matchCallback' => function ($rule, $action) {


                            if ($this->isUserAuthor()) {


                                return true;


                            }


                            return false;


                        }


                    ],


                    [


                        'actions' => ['deleteinlist'],


                        'allow' => true,


                        'roles' => ['@'],


                        'matchCallback' => function ($rule, $action) {


                            if ($this->isUserAuthor() || Yii::$app->getModule('users')->isAdmin()/* || $this->isMyProducts()*/) {


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


                    //'delete' => ['post'],


                ],


            ],


        ];


    }


    


    protected function isUserAuthor()


    {


        $user_id=Yii::$app->user->id;


        if(Yii::$app->getModule('users')->isPartners())


        {


            $partner=Userpartners::findOne(['partner_id' => Yii::$app->user->id]);


            $user_id=$partner->user_id;


        }


        return $this->findModel(Yii::$app->request->get('id'))->user_id == $user_id;


    }


    


    protected function isMyProducts()


    {


        return ArrayHelper::isIn($this->findModel(Yii::$app->request->get('id'))->product_id,Products::getUserproductsids());


    }


    


    public $layout = "@app/themes/mandelan/layouts/profile";





    /**


     * Lists all Productsopinion models.


     * @return mixed


     */


    public function actionMyproductsop()


    {


        $searchModel = new ProductsopinionSearch();


        $myprods['ProductsopinionSearch']['productlist']=Products::getUserproductsids();


        $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams,$myprods));





        return $this->render('index', [


            'searchModel' => $searchModel,


            'dataProvider' => $dataProvider,


        ]);


    }





    /**


     * Displays a single Productsopinion model.


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


     * Creates a new Productsopinion model.


     * If creation is successful, the browser will be redirected to the 'view' page.


     * @return mixed


     */


    public function actionCreate()


    {


        if(Yii::$app->user->isGuest)


            return $this->redirect(Usermodule::$loginUrl);


        


        if (Yii::$app->request->isAjax) {


        $model = new Productsopinion;


        


        if ($model->load(Yii::$app->request->post())) {


            Yii::$app->response->format = 'json';


            if($model->save($model)){


                return [


                    'succes' => 1,


                    'content' => $this->renderPartial('@webroot/modules/Products/views/products/_opinions', ['model'=>Products::findOne($model->product_id)]),


                    'count' => $model->product->opinionscount,


                    'average' => round($model->product->opinionsaverage,1),


                ];





            } else {


                return [


                    'succes' => 0,


                    'content' => '',


                ];


            }


        } else {


            $model->product_id=Yii::$app->request->get('id', 0);


            $model->user_id=Yii::$app->user->id;


            return $this->renderAjax('create', [


                'model' => $model,


            ]);


        }


        //Yii::$app->end();


        }


    }





    /**


     * Updates an existing Productsopinion model.


     * If update is successful, the browser will be redirected to the 'view' page.


     * @param integer $id


     * @return mixed


     */


    public function actionUpdate($id)


    {


        if (Yii::$app->request->isAjax) {


            $model = $this->findModel($id);





            if ($model->load(Yii::$app->request->post())) {


                Yii::$app->response->format = 'json';


                if($model->save($model)){


                    return [


                        'succes' => 1,


                        'content' => $this->renderPartial('@webroot/modules/Products/views/products/_opinions', ['model'=>Products::findOne($model->product_id)]),


                        'count' => $model->product->opinionscount,


                        'average' => round($model->product->opinionsaverage,1),


                    ];





                } else {


                    return [


                        'succes' => 0,


                        'content' => '',


                    ];


                }


            } else {


                return $this->renderAjax('update', [


                    'model' => $model,


                ]);


            }


        }


    }





    /**


     * Deletes an existing Productsopinion model.


     * If deletion is successful, the browser will be redirected to the 'index' page.


     * @param integer $id


     * @return mixed


     */


    public function actionDelete()


    {


        if (Yii::$app->request->isAjax) {


            $model = $this->findModel(Yii::$app->request->post('id'));


            $product=Products::findOne($model->product_id);


            


            Yii::$app->response->format = 'json';


            if($model->delete()){


                return [


                    'succes' => 1,


                    'content' => $this->renderPartial('@webroot/modules/Products/views/products/_opinions', ['model'=>$product]),


                    'count' => $product->opinionscount,


                    'average' => round($product->opinionsaverage,1),


                ];





            } else {


                return [


                    'succes' => 0,


                    'content' => '',


                ];


            }


        }


    }


    


    public function actionDeleteinlist()


    {


        $this->findModel(Yii::$app->request->get('id'))->delete();


        


        Yii::$app->session->setFlash('success', 'Vélemény törölve.');


        return $this->redirect('/products/productsopinion/myproductsop');


    }





    /**


     * Finds the Productsopinion model based on its primary key value.


     * If the model is not found, a 404 HTTP exception will be thrown.


     * @param integer $id


     * @return Productsopinion the loaded model


     * @throws NotFoundHttpException if the model cannot be found


     */


    protected function findModel($id)


    {


        if (($model = Productsopinion::findOne($id)) !== null) {


            return $model;


        } else {


            throw new NotFoundHttpException('The requested page does not exist.');


        }


    }


}


