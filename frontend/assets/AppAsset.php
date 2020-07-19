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
        'css/style.css',
        'css/catalog.css',
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVfJAnE_5h5-I10ARZhA3DAJ1_ELJ7JKA',
        'js/isotope.pkgd.min.js',
        'js/slick.min.js',
        'js/jquery-ias.min.js',
//        'js/map.js',
        'js/script.js',
        'js/catalog.js',
//        'js/ajax-nav.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
