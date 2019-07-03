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
        $newUsername=Yii::$app->user->getIdentity()->username;
        $bootstrap='<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
        $welcomeHTML="<div class=\"container\">
      <div class=\"row\">
        <div class=\"col-lg-12 text-center\">
          
          
        <div class=\"jumbotron\" style=\"\">		  <h1 class=\"display-3\">Hello, $newUsername!</h1>		  <p class=\"lead\">Your Madrapur account has been created, you can log in following the button below</p>		  <hr class=\"my-4\">		  		  <p class=\"lead\">			<a class=\"btn btn-primary btn-lg\" href=\"#\" role=\"button\">Log in</a>		  </p>		</div></div>
      </div>
    </div>";


        if($postedMail){
            $to = $postedMail['to'];
            $from=$postedMail['from'];
            $subject = $postedMail['subject'];
            $postedMail['date']=date('Y-m-d h:i');
            $postedMail['type']='Welcome';
            $postedMail['status']='sent';



            $txt = $bootstrap.$welcomeHTML;
            $postedMail['body']=$txt;
            $headers = "From: $from" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            if(mail($to,$subject,$txt,$headers)){
                Modmail::insertOne($model,$postedMail);
            }
        }

        $searchModel = new Modmail();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $gridColumns = [
            'id',
            'from',
            'subject',
            'to',
            'date',
            'status',
            'type',
            [
                'label' => 'View Mail',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Modmail/modmail/read?id='.$model->returnId().'">Read Mail'.'</a>';
                }
            ],


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
