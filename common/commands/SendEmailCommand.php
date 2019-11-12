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
class SendEmailCommand extends BaseObject implements SelfHandlingCommand {

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
        $mailData = [
            'to' => isLocalhost() ? 'admin@localhost' : $command->to,
            'from' => $command->from,
            'subject' => $command->subject,
            'type' => $command->type,
        ];

        $sent = Modmail::send($mailData);

        return $sent;
    }
}
