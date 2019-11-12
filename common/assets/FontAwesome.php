<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:24 PM
 */
namespace common\assets;

use yii\web\AssetBundle;

class FontAwesome extends AssetBundle {

    /**
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte';

    /**
     *
     * @var array
     */
    public $css = [
        'plugins/fontawesome-free/css/all.min.css'
    ];
}
