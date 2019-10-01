<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */
namespace common\assets;

use kartik\bs4dropdown\DropdownAsset;
use kartik\popover\PopoverXAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AdminLte extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    /**
     *
     * @var array
     */
    public $js = [
        'js/adminlte.js',


    ];

    /**
     *
     * @var array
     */
    public $css = [
        'css/adminlte.css',
        'css/adminlte.css.map',

    ];

    /**
     *
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        JuiAsset::class,
        FontAwesome::class,
        JquerySlimScroll::class
    ];
}
