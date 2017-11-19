<?php
/**
 * @link https://github.com/myzero1/tools
 * @copyright Copyright (c) 2013-2017 myzero1! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace myzero1\captcha\assets;
use yii\web\AssetBundle;
/**
 * FileUploadAsset
 *
 * @author Antonio Ramirez <myzero1@sina.com>
 */
class BlueimpFileUploadAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-file-upload';
    public $css = [
        'css/jquery.fileupload.css'
    ];
    public $js = [
        'js/vendor/jquery.ui.widget.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}