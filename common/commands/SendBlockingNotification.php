<?php
namespace common\commands;

use backend\modules\Modmail\models\Modmail;
use trntv\bus\interfaces\SelfHandlingCommand;
use Yii;
use yii\base\BaseObject;
use yii\swiftmailer\Message;

class SendBlockingNotification extends BaseObject implements SelfHandlingCommand {


    public $productName;


    public $timeBlockDate;

    public function handle($command) {
        $appId= Yii::$app->keyStorage->get('onesignal.appId');
        $apiKey= Yii::$app->keyStorage->get('onesignal.apiKey');

        if(!$appId || !$apiKey){
            sessionSetFlashAlert('warning','Notification Api not set, please contact the webmaster');
            return 0;
        }
        $username=\Yii::$app->user->getIdentity()->username;

        $content = array(
            "en" => "$command->productName full on $command->timeBlockDate( /$username)",
        );

        $fields = array(
            'app_id' => $appId,
            'included_segments' => ['blocking'],
            'data' => array("foo" => "bar"),
            'contents' => $content
        );

        $fields = json_encode($fields);




        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$apiKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;






    }
}
