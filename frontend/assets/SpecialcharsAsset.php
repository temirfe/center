<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SpecialcharsAsset extends AssetBundle
{
    //public $sourcePath = '@webroot';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/specialchars.js'
    ];
    public $depends = [
        'vova07\imperavi\Asset'
    ];
}
