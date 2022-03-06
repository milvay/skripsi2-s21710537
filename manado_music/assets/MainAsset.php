<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'wow/css/libs/animate.css',
        'font-awesome/css/font-awesome.min.css',
        'skitter/dist/skitter.css',
        'wow/css/site.css',
    ];
    public $js = [
        'js/main.js',
        'js/vue.min.js',
        'js/slider.js',
        'wow/dist/wow.min.js',
        //'skitter/examples/js/app.js',
        //'skitter/examples/js/jquery-2.1.1.min.js',
        'skitter/examples/js/jquery.easing.1.3.js',
        'skitter/dist/jquery.skitter.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
