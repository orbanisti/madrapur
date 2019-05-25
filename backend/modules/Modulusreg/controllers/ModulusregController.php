<?php

namespace backend\modules\Modulusreg\controllers;

use backend\modules\Modulusreg\models\Signupform;
use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Modulusreg` module
 */
class ModulusregController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
    public function actionSignup()
    {
        $model = new Signupform();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
