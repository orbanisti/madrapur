<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */

namespace frontend\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class FontAwesome4Asset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/fontawesome-free';
    
    public $css
        = [
            'css/fontawesome.min.css',
        ];
}