<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */
namespace backend\assets;

use common\assets\AdminLte;
use common\assets\Html5shiv;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class BackendAsset extends AssetBundle {

    /**
     *
     * @var string
     */
    public $basePath = '@webroot';

    /**
     *
     * @var string
     */
    public $baseUrl = '@web';

    /**
     *
     * @var array
     */
    public $css = [
        'css/style.css',
        'react-bundle/main-style.css',
    ];

    /**
     *
     * @var array
     */
    public $js = [
        'js/app.js',
        'react-bundle/main-script.js',
        'react-bundle/runtime-script.js'
    ];

    /**
     *
     * @var array
     */
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    /**
     *
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        AdminLte::class,
        Html5shiv::class
    ];
}
