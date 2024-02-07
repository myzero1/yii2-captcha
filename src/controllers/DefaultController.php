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
        $model=\Yii::$app->controller->module;
        // var_dump($model);exit;

        $code=\myzero1\captcha\helpers\Helper::getVerifyCode(
            $minLen = $model->minLen,
            $maxLen = $model->maxLen,
            $timeout = $model->timeout,
            $key = $model->key,
            $source = $model->source
        );

        setcookie(
            $name='Z1captchaId',
            $value = $code['id'],
            $expires_or_options = time() + $model->timeout,
            $path = "",
            $domain = "",
            $secure = false,
            $httponly = true
        );

        \myzero1\captcha\helpers\Helper::draw(
            $code['code'],
            $model->width ,
            $model->height ,
            [
                hexdec(substr($model->bgColor,-6,2)),
                hexdec(substr($model->bgColor,-4,2)),
                hexdec(substr($model->bgColor,-2,2))
            ],
            $fontSize = $model->fontSize,
            $startLeftTopPoint = $model->startLeftTopPoint,
            $noiseSpot = $model->noiseSpot,
            $noiseLine = $model->noiseLine
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

        $model=\Yii::$app->controller->module;
        $ok=\myzero1\captcha\helpers\Helper::validate(
            $id=$captchaId,
            $code=$code,
            $timeout = $model->timeout,
            $key = $model->key
        );
        if(!$ok){
            echo 0;
            exit;
        }

        echo 1;
        exit;
    }

}
