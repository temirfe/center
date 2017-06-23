<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class BxSliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'bxslider/jquery.bxslider.min.css',
    ];
    public $js = [
        'bxslider/jquery.bxslider.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
