<?php

namespace backend\modules\Modmail\controllers;

use backend\modules\Modmail\models\Mailtemplate;
use backend\modules\Modmail\models\Modmail;
use backend\modules\Product\models\ProductAdminSearchModel;
use function PHPSTORM_META\type;
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
        $newUsername=Yii::$app->user->getIdentity()->username;

        $welcomeHTML="<div class=\"container\">
      <div class=\"row\">
        <div class=\"col-lg-12 text-center\">
          
          
        <div class=\"jumbotron\" style=\"\">		  <h1 class=\"display-3\">Hello, $newUsername!</h1>		  <p class=\"lead\">Your Madrapur account has been created, you can log in following the button below</p>		  <hr class=\"my-4\">		  		  <p class=\"lead\">			<a class=\"btn btn-primary btn-lg\" href=\"#\" role=\"button\">Log in</a>		  </p>		</div></div>
      </div>
    </div>";

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
                    return '<a href="/Modmail/modmail/readmail?id='.$model->returnId().'">Read Mail'.'</a>';
                }
            ],
        ];

        $types = Mailtemplate::find()->all();
        $typesArray = [];

        Yii::error($types);

        foreach ($types as $type) {
            $typesArray[$type['id']] = $type['name'];
        }

        return $this->render('admin',['model'=>$model,'dataProvider'=>$dataProvider,'searchModel'=>$searchModel,'gridColumns'=>$gridColumns, 'types' => $typesArray]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionReadmail(){
        $mailID=Yii::$app->request->get('id');
        $mail=Modmail::findOne($mailID);





        return $this->render('readmail', [
            'email'=>$mail
        ]);

    }

    public function actionSend() {
        $data = Yii::$app->request->post('Modmail');
        $templateId = $data['type'];
        $model = new Modmail();

        $template = Mailtemplate::findOne(['=', 'id', $templateId]);
        $body = $template['body'];

        function get_string_between($string, $start, $end){
            $between = [];

            for ($i = 0; $i < count($start); ++$i) {
                $between[] = substr($string, $start[$i], $end[$i] - $start[$i]);
            }
            return $between;
        }

        $startNeedle = '{{';
        $lastStartPos = 0;
        $startPositions = [];

        while (($lastStartPos = strpos($body, $startNeedle, $lastStartPos))!== false) {
            $startPositions[] = $lastStartPos + strlen($startNeedle);
            $lastStartPos = $lastStartPos + strlen($startNeedle);
        }

        $endNeedle = '}}';
        $lastEndPos = 0;
        $endPositions = [];

        while (($lastEndPos = strpos($body, $endNeedle, $lastEndPos))!== false) {
            $endPositions[] = $lastEndPos;
            $lastEndPos = $lastEndPos + strlen($endNeedle);
        }

        $templateFields = get_string_between($body, $startPositions, $endPositions);

        if ($data && Yii::$app->request->post('sendNow')) {
            Modmail::sendWithReplace($data, $startPositions, $endPositions, $templateFields);
        }

        if ($data && Yii::$app->request->post('preview')) {
            $file = file_get_contents("VvvebJs/tmp-email-$templateId.html");

            function set_strings($body, $templateFields){
                foreach ($templateFields as $field) {
                    $body = str_replace("{{".$field."}}", Yii::$app->request->post($field), $body);
                }
                return $body;
            }

            $txt = set_strings($file, $templateFields);

            return var_dump($txt);
        }

        return $this->render('send', [
            'model' => $model,
            'data' => $data,
            'template' => $template,
            'templateFields' => $templateFields
        ]);
    }
}
