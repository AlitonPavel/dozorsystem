<?php

namespace app\assets;

use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        '/css/jquery-ui.css',
    ];

    public $js = [
        '/js/jquery-ui.min.js',
    ];

    public $depends = [
        '\yii\web\JqueryAsset'
    ];
}
