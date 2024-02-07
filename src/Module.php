<?php

namespace myzero1\captcha;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

/**
 * captcha module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $maxLen = 6; //最大显示个数
    public $minLen = 6; //最少显示个数
    public $timeout = 300; //过期时间，单位为秒
    public $key = 'myzero1自研'; //用于验证码加密
    public $source = '0123456789abcdefghijklmnopqrstuvwxyz'; //候选字符，不支持中文的图片渲染，但支持生成中文验证码
    public $width = 130;  //宽度
    public $height = 32; //高度
    public $bgColor = '#dddddd'; //背景颜色,六位的rgb
    public $fontSize = 14; //字体大小
    public $startLeftTopPoint = [10,5]; //字符起点的左上角坐标
    public $noiseSpot = 50; //干扰点数量
    public $noiseLine = 3; //干扰线数量

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'myzero1\captcha\controllers';


    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->attachBehavior('captchaValidateBehavior',[
                'class' => \myzero1\captcha\behaviors\CaptchaValidateBehavior::class,
            ]
        );

    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}
