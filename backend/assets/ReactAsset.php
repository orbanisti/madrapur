<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */
namespace backend\assets;

use yii\web\AssetBundle;

class ReactAsset extends AssetBundle {

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
        'react-bundle/main-style.css',
    ];

    /**
     *
     * @var array
     */
    public $js = [
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
        BackendAsset::class
    ];
}
