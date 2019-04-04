<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace frontend\assets;

use common\assets\Html5shiv;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@frontend/web/bundle';

    /**
     *
     * @var array
     */
    public $css = [
        'app-style.css',
        '1-style.css',
        '2-style.css',
        '3-style.css',
        '4-style.css',
    ];

    /**
     *
     * @var array
     */
    public $js = [
        'app-script.js',
        '1-script.js',
        '2-script.js',
        '3-script.js',
        '4-script.js'
    ];

    /**
     *
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        Html5shiv::class,
    ];
}
