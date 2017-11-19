<?php

namespace myzero1\yii2upload\controllers;

use yii\web\Controller;

/**
 * Default controller for the `tools` module
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
}
