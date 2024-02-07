<?php

namespace myzero1\captcha\controllers;

use yii\web\Controller;

/**
 * Default controller for the `captcha` module
 */
class DefaultController extends Controller
{
    // public function actions()
    // {
    //     return  [
    //         'captcha' => [
    //             'class' => 'yii\captcha\CaptchaAction',
    //             'fixedVerifyCode' => $this->module->fixedVerifyCode,
    //             'backColor'=> $this->module->backColor,//背景颜色
    //             'maxLength' => $this->module->maxLength, //最大显示个数
    //             'minLength' => $this->module->minLength,//最少显示个数
    //             'padding' => $this->module->padding,//间距
    //             'height'=> $this->module->height,//高度
    //             'width' => $this->module->width,  //宽度
    //             'foreColor' => $this->module->foreColor,     //字体颜色
    //             'offset' => $this->module->offset,        //设置字符偏移量 有效果
    //             'transparent' => $this->module->transparent,        //设置字符偏移量 有效果
    //         ],
	// 	];
	// }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDemo()
    {
        if (\Yii::$app->request->isPost) {
            var_dump('Captcha is validated.');exit;
        } else {
            return $this->render('demo');
        }

    }

    public function actionCaptcha()
    {
        // 0x3c8dbc
        // 'backColor' => 0x3c8dbc, //背景颜色
        $bgColor='0x3c8dbc';
        $bgColor='#d2d6de';

        $code=\myzero1\captcha\helpers\Helper::getVerifyCode(
            $minLen = 4,
            $maxLen = 4,
            $timeout = 300,
            $key = 'myzero1自研',
            $source = '0123456789abcdefghijklmnopqrstuvwxyz'
        );

        setcookie(
            $name='Z1captchaId',
            $value = $code['id'],
            $expires_or_options = time() + 300,
            $path = "",
            $domain = "",
            $secure = false,
            $httponly = true
        );

        \myzero1\captcha\helpers\Helper::draw(
            $code['code'],
            100,
            32,
            [
                hexdec(substr($bgColor,-6,2)),
                hexdec(substr($bgColor,-4,2)),
                hexdec(substr($bgColor,-2,2))
            ],
            $fontSize = 16,
            $startLeftTopPoint = [10,5],
            $noiseSpot = 1,
            $noiseLine = 3
        );
        exit;
    }

    public function actionCaptchaValidate()
    {
        $code=\Yii::$app->request->get('code','');
        if (!$code) {
            echo 0;
            exit;
        }

        $cookie=\Yii::$app->request->headers->get('cookie');
        $info=explode(';',$cookie);
        $flag='Z1captchaId=';
        $captchaId='';
        foreach ($info as $k => $v) {
            if (strpos($v,$flag)!==false) {
                $captchaId=str_replace($flag,'',$v);
            }
        }
        if (!$captchaId) {
            echo 0;
            exit;
        }

        $ok=\myzero1\captcha\helpers\Helper::validate(
            $id=$captchaId,
            $code=$code,
            $timeout = 300,
            $key = 'myzero1自研'
        );
        if(!$ok){
            echo 0;
            exit;
        }

        echo 1;
        exit;
    }

}
