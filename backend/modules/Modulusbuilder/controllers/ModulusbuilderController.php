<?php

namespace backend\modules\Modulusbuilder\controllers;

use backend\modules\Modmail\models\Mailtemplate;
use Yii;
use backend\controllers\Controller;
use yii\debug\models\search\Mail;

/**
 * Controller for the `Modulusbuilder` module
 */
class ModulusbuilderController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->renderPartial('admin');
    }

    public function actionUpdate() {
        return $this->renderPartial('update');
    }


    public function actionEmail(){
        $model=new Mailtemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'email'
            ]);
        }

        $searchModel=new Mailtemplate();
        $dataProvider=$model->search([]);
        return $this->render('email',['model'=>$model,'dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);

    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public static function getContent($id = "") {
        $query = Mailtemplate::aSelect(Mailtemplate::class, '*', Mailtemplate::tableName(), "`id` LIKE '$id'");

        return $query->one();
    }
    public static function setContent($id, $content){
        $query = Mailtemplate::aSelect(Mailtemplate::class, '*', Mailtemplate::tableName(), "`id` LIKE '$id'");

        $row=$query->one();
        $values = [
            'body' => $content,


        ];

        if (Mailtemplate::insertOne($row, $values)) {
            $returnMessage = 'Successfully Saved'.$content.$id;

        } else {
            $returnMessage = 'Save not Succesful';

        }
        return $returnMessage;


    }
}
