<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace myzero1\captcha\widget\upload;

use yii\web\AssetBundle;

class CaptchaAsset extends AssetBundle
{

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
        $this->css = [
            YII_DEBUG ? 'css/upload-kit.css' : 'css/upload-kit.min.css'
        ];

        $this->js = [
            YII_DEBUG ? 'js/upload-kit.js' : 'js/upload-kit.min.js'
        ];
        parent::init();
    }
}
