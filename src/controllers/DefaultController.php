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
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                // 'backColor'=>0x000000,//背景颜色
                'maxLength' => 3, //最大显示个数
                'minLength' => 3,//最少显示个数
                // 'padding' => 5,//间距
                // 'height'=>40,//高度
                // 'width' => 130,  //宽度
                // 'foreColor'=>0xffffff,     //字体颜色
                // 'offset'=>4,        //设置字符偏移量 有效果
                // 'transparent'=>true,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],
		];
	}

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        var_dump($this->module);exit;
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
