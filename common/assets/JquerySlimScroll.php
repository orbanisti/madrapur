<?php
namespace common\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class JquerySlimScroll
 *
 * @package common\assets
 * @author Eugene Terentev <eugene@terentev.net>
 */
class JquerySlimScroll extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte';

    public $css =['plugins/overlayScrollbars/css/OverlayScrollbars.min.css'];

    /**
     *
     * @var array
     */
    public $js = [
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'
    ];

    /**
     *
     * @var array
     */
    public $depends = [
        JqueryAsset::class
    ];
}
