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
