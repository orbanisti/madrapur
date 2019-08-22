<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */
namespace backend\assets;


use yii\web\AssetBundle;
use yii\web\YiiAsset;

class MaterializeAsset extends AssetBundle {

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
        'css/materialize.min.css',
    ];

    /**
     *
     * @var array
     */
    public $js = [
        'js/materialize.min.js',
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
        YiiAsset::class,

    ];
}
