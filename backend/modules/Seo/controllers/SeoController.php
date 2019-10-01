<?php

namespace backend\modules\Seo\controllers;

use backend\modules\content\models\search\ArticleSearch;
use backend\modules\Seo\models\Seo;
use common\models\Article;
use common\models\ArticleCategory;
use Yii;
use backend\controllers\Controller;
use yii\web\Response;

/**
 * Controller for the `Seo` module
 */
class SeoController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'published_at' => SORT_DESC
            ],
        ];

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }


    public function actionUpdate($id) {
        $article = Article::findOne($id);

        $seomodel=Seo::find()->where('postId='.$id)->one();
        if(!$seomodel){
            $seomodel=new Seo();
        }


        if ($article->load(Yii::$app->request->post()) && $article->save()) {
            return $this->redirect([
                                       'index'
                                   ]);
        }

        if($seomodel->load(Yii::$app->request->post()) && $seomodel->save()){


            return $this->renderAjax('update',
                                     [
                                         'model' => $article,
                                         'categories' => ArticleCategory::find()->active()
                                             ->all(),
                                         'seomodel'=>$seomodel,
                                         'pleaseRefresh'=>true
                                     ]);
        }


        return $this->render('update',
                             [
                                 'model' => $article,
                                 'categories' => ArticleCategory::find()->active()
                                     ->all(),
                                 'seomodel'=>$seomodel
                             ]);
    }


    public function actionGeneratemeta($id){
            $posted=Yii::$app->request->post('Seo');
            if(!$posted) {
                $model = Article::findOne($id);

                $texttoecho = '';
                $seomodel = Seo::find()->where('postId=' . $id)->one();

                if ($seomodel) {
                    $pyscript = 'C:\\MadraPurFinal\\madrapur\\backend\\modules\\Seo\\views\\seo\\metadesc.py';
                    $python = 'C:\\Users\\ROG\\AppData\\Local\\Programs\\Python\\Python37-32\\python.exe';
                    $cmd = "$python $pyscript " . $id;
                    #$texttoecho.=$cmd;
                    $result = exec($cmd, $output, $return);

                    $texttoecho = ($output);
                }
            }
            else{
                $seomodel = Seo::find()->where('postId=' . $id)->one();
                if($seomodel->load(Yii::$app->request->post()) && $seomodel->save()){




                    return $this->renderAjax('generatemeta',['posted'=>$posted]);

                }

            }

        return $this->renderAjax('generatemeta',
                             ['model'=>$model,
                              'content'=>$texttoecho,
                              'posted'=>$posted
                             ]);

    }
}
