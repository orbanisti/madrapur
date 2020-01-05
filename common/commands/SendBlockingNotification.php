<?php
namespace common\commands;

use backend\modules\Modmail\models\Modmail;
use trntv\bus\interfaces\SelfHandlingCommand;
use yii\base\BaseObject;
use yii\swiftmailer\Message;

/**
 *
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SendBlockingNotification extends BaseObject implements SelfHandlingCommand {

    /**
     *
     * @var mixed
     */
    public $from;

    /**
     *
     * @var mixed
     */
    public $to;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     *
     * @param \common\commands\SendEmailCommand $command
     * @return bool
     */
    public function handle($command) {


        $username=\Yii::$app->user->getIdentity()->username;

        $content = array(
            "en" => "$command->productName full on $command->timeBlockDate( /$username)",
        );

        $fields = array(
            'app_id' => "a8ec6648-23b1-4707-8d5c-77f99eeb0a18",
            'included_segments' => ['blocking'],
            'data' => array("foo" => "bar"),
            'contents' => $content
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic ZDAwMzM5NGItMjdmYy00YTA4LWI2NDItNTdlNWJhY2Q4OGQ2'));
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
