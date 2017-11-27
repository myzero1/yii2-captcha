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
        $app->params['captchaModel'] = new \myzero1\captcha\models\Captcha();
        $app->attachBehavior('PreventMultipleSubmissions1',[
            // 'class' => backend\behaviors\PreventMultipleSubmissionsBehavior::class,
                'class' => \myzero1\captcha\behaviors\PreventMultipleSubmissionsBehavior::class,
                'excludedRoutes' => []
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
