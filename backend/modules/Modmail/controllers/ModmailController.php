<?php

namespace backend\modules\Modmail\controllers;

use backend\modules\Modmail\models\Modmail;
use backend\modules\Product\models\ProductAdminSearchModel;
use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Modmail` module
 */
class ModmailController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $model=new Modmail();
        $postedMail=Yii::$app->request->post('Modmail');



        if($postedMail){

            $to = $postedMail['to'];
            $from=$postedMail['from'];
            $subject = $postedMail['subject'];
            $txt = $postedMail['body'];
            $headers = "From: $from" . "\r\n";

            if(mail($to,$subject,$txt,$headers)){
                Modmail::insertOne($model,$postedMail);
            }


        }

        $searchModel = new Modmail();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $gridColumns = [
            'id',
            'from',
            'to',
            'date',
            'status',
            'type',

        ];




        return $this->render('admin',['model'=>$model,'dataProvider'=>$dataProvider,'searchModel'=>$searchModel,'gridColumns'=>$gridColumns]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
