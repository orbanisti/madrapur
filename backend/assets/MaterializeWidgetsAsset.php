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

class MaterializeWidgetsAsset extends AssetBundle {

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
        'css/materializeWidgets.min.css',

    ];

    /**
     *
     * @var array
     */


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
