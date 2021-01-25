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
        'https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet',
        'css/font-awesome.min.css',
        'css/elegant-icons.css',
        'css/magnific-popup.css',
        'css/nice-select.css',
        'css/owl.carousel.min.css',
        'css/slicknav.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.nice-select.min.js',
        'js/jquery.nicescroll.min.js',
        'js/jquery.magnific-popup.min.js',
        'js/jquery.countdown.min.js',
        'js/jquery.slicknav.js',
        'js/mixitup.min.js',
        'js/owl.carousel.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
