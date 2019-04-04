<?php

namespace api\modules\v1\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Worker` module
 */
class WorkerController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actions()
    {
        return array(
            'index' => array(
                'class' => \nizsheanez\jsonRpc\Action::class,
            ),
        );
    }

    public function yell($message) {
        return $message;
    }
}
