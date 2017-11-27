<?php

namespace myzero1\captcha\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;
use yii\web\BadRequestHttpException;
use Gregwar\Captcha\CaptchaBuilder;



/**
 * Class PreventMultipleSubmissionsBehavior
 * @package myzero1\pms\behaviors
 */
class PreventMultipleSubmissionsBehavior extends Behavior
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
        if (!in_array(Yii::$app->request->method, ['GET', 'HEAD', 'OPTIONS'], true)) {

            $model = new \myzero1\captcha\models\Captcha();

            $url = '/' . \Yii::$app->requestedRoute;

            // Header("Location: $url");
            Yii::$app->getSession()->setFlash('success', '保存成功');
            \Yii::$app->response->redirect($url)->send();

            return Yii::$app->controller->redirect('/' . \Yii::$app->requestedRoute);

                // var_dump(\Yii::$app->requestedRoute);exit;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            } else {
                var_dump(\Yii::$app->requestedRoute);exit;

                $action = Yii::$app->controller->action;
                if(!$action instanceof \yii\web\ErrorAction) {
                    throw new BadRequestHttpException(Yii::t('yii', 'Please do not repeat the submission.'));
                } else {
                    # will finish it.
                }
            }

            // var_dump('expression');exit;
        }
        return false;
    }
}