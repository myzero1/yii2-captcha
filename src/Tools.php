<?php

namespace myzero1\captcha;

/**
 * tools module definition class
 */
class Tools extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'myzero1\captcha\controllers';

    /**
     * @ array
     */
    public $upload;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->addUpload();

    }

    private function addUpload()
    {
        \Yii::$app->set(
            'fileStorage',
            [
                'class' => '\trntv\filekit\Storage',
                'baseUrl' => $this->upload['baseUrl'],
                'filesystem'=> function() {
                    $basePath = \Yii::getAlias($this->upload['basePath']);
                    $adapter = new \League\Flysystem\Adapter\Local($basePath);
                    return new \League\Flysystem\Filesystem($adapter);
                }
            ]
        );
    }
}
