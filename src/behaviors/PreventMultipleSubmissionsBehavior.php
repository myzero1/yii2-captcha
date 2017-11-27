<?php

namespace myzero1\pms\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;
use yii\web\BadRequestHttpException;

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
        // Add the js to prevent multiple submissions.
        \Yii::$app->view->registerAssetBundle('myzero1\pms\assets\PreMulSubmissionsAsset');

        if (!in_array(Yii::$app->request->method, ['GET', 'HEAD', 'OPTIONS'], true)) {

            if (!in_array(\Yii::$app->requestedRoute, $this->excludedRoutes)) {
                $lastActionParamsHash = md5(json_encode(Yii::$app->request->post()));
                $lastActionParamsHashSession = Yii::$app->getSession()->get('lastActionParamsHash', false);
                file_put_contents('log', json_encode(Yii::$app->request->post()) . "_json\n", FILE_APPEND);
                file_put_contents('log', $lastActionParamsHashSession . "_session\n", FILE_APPEND);
                file_put_contents('log', $lastActionParamsHash . "_hash\n", FILE_APPEND);
                if ($lastActionParamsHash == $lastActionParamsHashSession) {
                    $action = Yii::$app->controller->action;
                    if(!$action instanceof \yii\web\ErrorAction) {
                        throw new BadRequestHttpException(Yii::t('yii', 'Please do not repeat the submission.'));
                    } else {
                        # will finish it.
                    }
                } else {
                    Yii::$app->getSession()->set('lastActionParamsHash', $lastActionParamsHash);
                }
            }
        }
    }
}
