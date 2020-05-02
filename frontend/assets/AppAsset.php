<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/price-range.css',
        'css/animate.css',
        'css/main.css',
        'css/responsive.css',
        'css/slick.css',
        'https://unpkg.com/swiper/css/swiper.min.css',
    ];
    public $js = [
        'js/jquery.scrollUp.min.js',
        'js/price-range.js',
        'js/slick.min.js',
        'js/main.js',
        'js/language-selection.js',
        'js/currency-selection.js',
        'https://unpkg.com/swiper/js/swiper.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
