<?php
namespace myzero1\captcha\widget\upload;
//upload
use yii\web\AssetBundle;

class BlueimpCanvasToBlobAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-canvas-to-blob';

    public $js = [
        'js/canvas-to-blob.min.js'
    ];
}
