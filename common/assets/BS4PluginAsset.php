<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */
namespace common\assets;

use backend\assets\BackendAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class BS4PluginAsset extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    /**
     *
     * @var array
     */


    /**
     *
     * @var array
     */
    public $css = [
        'icheck-bootstrap/icheck-bootstrap.css',

    ];

    /**
     *
     * @var array
     */
}
