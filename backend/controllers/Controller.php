<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 10:57
 */

namespace backend\controllers;


class Controller extends \yii\web\Controller {
    public function redirectToAdmin() {
        if(!false)
            //return $this->redirect(\yii\helpers\Url::current());
            return true;
        else return true;
    }
}