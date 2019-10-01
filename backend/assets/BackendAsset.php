<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */
namespace backend\assets;

use common\assets\AdminLte;
use common\assets\BS4PluginAsset;
use common\assets\Html5shiv;
use kartik\bs4dropdown\DropdownAsset;
use yii\bootstrap4\BootstrapPluginAsset;
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
    ];

    /**
     *
     * @var array
     */
    public $js = [
        'js/app.js',
    ];

    /**
     *
     * @var array
     */
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    /**
     *
     * @var array
     */
    public $depends = [
        BS4PluginAsset::class,
        BootstrapPluginAsset::class,
        YiiAsset::class,
        AdminLte::class,
        Html5shiv::class,
    ];
}
