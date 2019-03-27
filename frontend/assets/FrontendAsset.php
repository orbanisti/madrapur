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
        'style.css',
        'app.css',
        '2.css',
        '3.css',
    ];

    /**
     *
     * @var array
     */
    public $js = [
        'app.js',
        '1.js',
        '2.js',
        '3.js',
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
