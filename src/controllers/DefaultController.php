<?php

namespace myzero1\captcha\controllers;

use yii\web\Controller;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Default controller for the `captcha` module
 */
class DefaultController extends Controller
{
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
		$builder = new CaptchaBuilder;
		$builder->build();

		header('Content-type: image/jpeg');
		$builder->output();
    }
}
