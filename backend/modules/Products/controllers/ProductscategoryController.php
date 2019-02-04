<?php

namespace backend\modules\Products

namespace app\modules\Products\controllers;



use Yii;

use app\modules\Products\models\Productscategory;

use app\modules\Products\models\ProductscategorySearch;

//use yii\web\Controller;

use app\components\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use lajax\translatemanager\models\Language;

use app\base\Model;

use yii\helpers\ArrayHelper;

use \app\modules\Products\models\Productscategorytranslate;



/**

 * ProductscategoryController implements the CRUD actions for Productscategory model.

 */

class ProductscategoryController extends Controller

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

                        /*'roles' => ['*'],*/

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

                ],

            ],

        ];

    }



    /**

     * Lists all Productscategory models.

     * @return mixed

     */

    public function actionAdmin()

    {

        $searchModel = new ProductscategorySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('admin', [

            'searchModel' => $searchModel,

            'dataProvider' => $dataProvider,

        ]);

    }



    /**

     * Displays a single Productscategory model.

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

     * Creates a new Productscategory model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     * @return mixed

     */

    public function actionCreate()

    {

        $model = new Productscategory();



        $modelTranslations = [];

        

        foreach (Language::getLanguages() as $language) {

            if($language->language_id!=Yii::$app->sourceLanguage) {

                $langId=$language->language_id;

        	$translation = new Productscategorytranslate;

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

                    $modelTranslation->category_id = $model->id;

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

    }



    /**

     * Updates an existing Productscategory model.

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

        	$translation = Productscategorytranslate::findOne(['category_id'=>$model->id, 'lang_code'=>$langId]);

        	if(empty($translation)) {

        		$translation = new Productscategorytranslate;

                        $translation->category_id = $model->id;

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

    }



    /**

     * Deletes an existing Productscategory model.

     * If deletion is successful, the browser will be redirected to the 'index' page.

     * @param integer $id

     * @return mixed

     */

    public function actionDelete($id)

    {

        Productscategorytranslate::deleteAll(['category_id'=>$id]);

        

        $this->findModel($id)->delete();



        return $this->redirect(['admin']);

    }



    /**

     * Finds the Productscategory model based on its primary key value.

     * If the model is not found, a 404 HTTP exception will be thrown.

     * @param integer $id

     * @return Productscategory the loaded model

     * @throws NotFoundHttpException if the model cannot be found

     */

    protected function findModel($id)

    {

        if (($model = Productscategory::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }

    }

}

