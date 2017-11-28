<?php

namespace myzero1\captcha\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;
use yii\web\BadRequestHttpException;
use Gregwar\Captcha\CaptchaBuilder;
use yii\helpers\Json;



/**
 * Class PreventMultipleSubmissionsBehavior
 * @package myzero1\pms\behaviors
 */
class CaptchaValidateBehavior extends Behavior
{
    /**
     * @var array  ['site/index', 'site/login']
     */
    public $excludedRoutes = [];

    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction()
    {
        if (in_array(Yii::$app->request->method, ['POST'], true)) {
            // var_dump('expression');exit;
            $model = new \myzero1\captcha\models\Captcha();
            // $model->scenario = 'beforeAction';
            $model->scenario = 'jsPhp';

            $post = Yii::$app->request->post();

            if (isset($post['Captcha']) && isset($post['Captcha']['verifyCode'])) {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                } else {
                    unset($post['Captcha']);
                    unset($post[Yii::$app->request->csrfParam]);

                    $postJson = Json::encode($post);
                    Yii::$app->getSession()->setFlash('captcha_form_data', $postJson);
                    $url = '/' . \Yii::$app->requestedRoute;
                    \Yii::$app->response->redirect($url)->send();
                }
            }
        }
    }
}