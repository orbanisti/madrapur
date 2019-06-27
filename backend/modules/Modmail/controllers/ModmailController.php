<?php

namespace backend\modules\Modmail\controllers;

use backend\modules\Modmail\models\Modmail;
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

/*
            Yii::$app->mailer->compose()
                ->setTo($postedMail['to'])
                ->setFrom($postedMail['from'])
                ->setSubject($postedMail['subject'])
                ->setHtmlBody($postedMail['body'])
                ->send();*/
            $to = $postedMail['to'];
            $from=$postedMail['from'];
            $subject = $postedMail['subject'];
            $txt = $postedMail['body'];
            $headers = "From: $from" . "\r\n";

            mail($to,$subject,$txt,$headers);


        }





        return $this->render('admin',['model'=>$model]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
