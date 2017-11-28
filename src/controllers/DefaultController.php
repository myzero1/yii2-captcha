<?php

namespace myzero1\captcha\controllers;

use yii\web\Controller;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Default controller for the `captcha` module
 */
class DefaultController extends Controller
{
    public function actions()
    {
        return  [
            // 'captcha' =>
            //    [
            //        'class' => 'yii\captcha\CaptchaAction',
            //        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            //    ],  //默认的写法
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => $this->module->fixedVerifyCode,
                'backColor'=> $this->module->backColor,//背景颜色
                'maxLength' => $this->module->maxLength, //最大显示个数
                'minLength' => $this->module->minLength,//最少显示个数
                'padding' => $this->module->padding,//间距
                'height'=> $this->module->height,//高度
                'width' => $this->module->width,  //宽度
                'foreColor' => $this->module->foreColor,     //字体颜色
                'offset' => $this->module->offset,        //设置字符偏移量 有效果
                'transparent' => $this->module->transparent,        //设置字符偏移量 有效果
            ],
		];
	}

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        var_dump($this->module->sController);exit;
        return $this->render('index');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCaptcha1()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $_SESSION['phrase'] = $builder->getPhrase();
        header('Content-type: image/jpeg');
        $builder->output();
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

}
