<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace frontend\assets;

use common\assets\Html5shiv;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class MdbCheckboxAsset extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@frontend/web/bundle/mdbpro';

    /**
     *
     * @var array
     */
    public $css = [
        'css/mdb-checkboxes.css',
    ];

    /**
     *
     * @var array
     */

    /**
     *
     * @var array
     */
    public $depends = [
        FontAwesome4Asset::class,
        JqueryAsset::class,
        BootstrapPluginAsset::class,
        FontAwesome4Asset::class,
    ];
}
