<?php

namespace myzero1\captcha\controllers;


use yii\web\Controller;

/**
 * Default controller for the `tools` module
 */
class CaptchaController extends Controller
{
    public function init(){
        parent::init();
    }

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
    public function actionCaptcha()
    {
        return $this->render('index');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionTest()
    {
        return $this->render('test');
    }
}
