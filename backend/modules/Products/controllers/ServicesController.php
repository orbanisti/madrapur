<?php

namespace backend\modules\Products\controllers;





use Yii;


use backend\modules\Products\models\Services;


use backend\modules\Products\models\ServicesSearch;


//use yii\web\Controller;


use backend\components\Controller;


use yii\web\NotFoundHttpException;


use yii\filters\VerbFilter;


use yii\filters\AccessControl;


use lajax\translatemanager\models\Language;


use backend\modules\Products\models\Servicestranslate;


use backend\base\Model;


use yii\helpers\ArrayHelper;





/**


 * ServicesController implements the CRUD actions for Services model.


 */


class ServicesController extends Controller


{


    public function behaviors()


    {


        return [


            'access' => [


                'class' => AccessControl::className(),


                'rules' => [


                    [


                        'actions' => ['getlistbycategory'],


                        'allow' => true,


                    ],


                    [


                        'actions' => ['admin','create','update','delete'],


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


                    'getlistbycategory' => ['post'],


                ],


            ],


        ];


    }





    /**


     * Lists all Services models.


     * @return mixed


     */


    public function actionAdmin()


    {


        $searchModel = new ServicesSearch();


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);





        return $this->render('admin', [


            'searchModel' => $searchModel,


            'dataProvider' => $dataProvider,


        ]);


    }


    


    


    public function actionGetlistbycategory()


    {


        if (Yii::$app->request->isAjax) {


            $catid=Yii::$app->request->post('category');


            $services=Services::find()->where('`categories` LIKE "%\"'.$catid.'\"%"')->all();


            


            $return='';


            


            foreach ($services as $service){


                $return.='<label><input type="checkbox" name="Products[serviceslist][]" value="'.$service->id.'"> '.$service->name.'</label>';


            }


            


            return $return;


        }


        return false;


    }





    /**


     * Displays a single Services model.


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


     * Creates a new Services model.


     * If creation is successful, the browser will be redirected to the 'view' page.


     * @return mixed


     */


    public function actionCreate()


    {


        $model = new Services();


        $modelTranslations = [];


        


        foreach (Language::getLanguages() as $language) {


            if($language->language_id!=Yii::$app->sourceLanguage) {


                $langId=$language->language_id;


        	$translation = new Servicestranslate;


		$translation->lang_code = $langId;


                $modelTranslations[] = $translation;


            }


        }


        


        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            $modelTranslationsIDs = ArrayHelper::map($modelTranslations, 'id', 'id');


            //$modelTranslations = Model::createMultiple(StaticpagesTranslate::classname(), $modelTranslations);


            Model::loadMultiple($modelTranslations, Yii::$app->request->post());





            foreach ($modelTranslations as $modelTranslation) {


                if(!empty($modelTranslation->name)) {


                    $modelTranslation->service_id = $model->id;


                    $modelTranslation->save();


                }


            }


             return $this->redirect(['update', 'id' => $model->id]);


        } else {


            return $this->render('create', [


                'model' => $model,


                'modelTranslations' => $modelTranslations


            ]);


        }





        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {


            return $this->redirect(['update', 'id' => $model->id]);


        } else {


            return $this->render('create', [


                'model' => $model,


            ]);


        }*/


    }





    /**


     * Updates an existing Services model.


     * If update is successful, the browser will be redirected to the 'view' page.


     * @param integer $id


     * @return mixed


     */


    public function actionUpdate($id)


    {


        $model = $this->findModel($id);


        $modelTranslations = $model->translations;


        


        foreach (Language::getLanguages() as $language) {


            if($language->language_id!=Yii::$app->sourceLanguage) {


                $langId=$language->language_id;


        	$translation = Servicestranslate::findOne(['service_id'=>$model->id, 'lang_code'=>$langId]);


        	if(empty($translation)) {


        		$translation = new Servicestranslate;


                        $translation->service_id = $model->id;


			$translation->lang_code = $langId;


                        $modelTranslations[] = $translation;


        	}


            }


        }





        if ($model->load(Yii::$app->request->post())) {


            $modelTranslationsIDs = ArrayHelper::map($modelTranslations, 'id', 'id');


            Model::loadMultiple($modelTranslations, Yii::$app->request->post());


            


            foreach ($modelTranslations as $modelTranslation) {


                if(!$modelTranslation->isNewRecord && empty($modelTranslation->name))


                    $modelTranslation->delete();


                elseif(!empty($modelTranslation->name))


                    $modelTranslation->save();


            }


            


            $model->save();


            


            return $this->redirect('admin');


        } else {


            return $this->render('update', [


                'model' => $model,


                'modelTranslations' => $modelTranslations


            ]);


        }


        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {


            return $this->redirect(['update', 'id' => $model->id]);


        } else {


            return $this->render('update', [


                'model' => $model,


            ]);


        }*/


    }





    /**


     * Deletes an existing Services model.


     * If deletion is successful, the browser will be redirected to the 'index' page.


     * @param integer $id


     * @return mixed


     */


    public function actionDelete($id)


    {


        $this->findModel($id)->delete();





        return $this->redirect(['admin']);


    }





    /**


     * Finds the Services model based on its primary key value.


     * If the model is not found, a 404 HTTP exception will be thrown.


     * @param integer $id


     * @return Services the loaded model


     * @throws NotFoundHttpException if the model cannot be found


     */


    protected function findModel($id)


    {


        if (($model = Services::findOne($id)) !== null) {


            return $model;


        } else {


            throw new NotFoundHttpException('The requested page does not exist.');


        }


    }


}


