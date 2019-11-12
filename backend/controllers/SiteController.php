<?php
namespace backend\controllers;

use backend\modules\Tickets\controllers\TicketsController;
use common\models\User;
use Yii;
use yii\base\InvalidRouteException;
use yii\console\Exception;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller {

    /**
     *
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action) {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';

        return parent::beforeAction($action);
    }

    public static function getActionBan($controller, $action) {
        $hasAccess = true;

        if (class_exists($controller) && property_exists($controller, "bans")) {
            if (isset($controller::$bans[$action])) {
                $actionBans = $controller::$bans[$action];

                foreach ($actionBans as $ban) {
                    if (User::findByUsername(Yii::$app->user->identity->username)->hasRole($ban)) {
                        $hasAccess = false;
                        break;
                    }
                }
            }
        }

        return $hasAccess;

    }
}
