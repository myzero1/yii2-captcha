<?php

namespace myzero1\captcha\controllers;


use yii\web\Controller;
use myzero1\captcha\components\UploadHandler;

/**
 * Default controller for the `tools` module
 */
class UploadController extends Controller
{
    public $aValidationRules;

    public function init(){
        parent::init();

        $uploadhash = \Yii::$app->request->get('uploadhash');
        $sValidationRules = \Yii::$app->session->get($uploadhash);
        $aValidationRules = $sValidationRules ? \yii\helpers\Json::decode($sValidationRules) : array();
        $aTmp = ['file','file'];
        $aValidationRules = array_merge($aTmp, $aValidationRules);

        $this->aValidationRules = $aValidationRules;
        // var_dump($this->aValidationRules[0]);exit;
    }

    public function actions(){
        return [
           'upload'=>[
               'class'=>'trntv\filekit\actions\UploadAction',
               //'deleteRoute' => 'my-custom-delete', // my custom delete action for deleting just uploaded files(not yet saved)
               //'fileStorage' => 'myfileStorage', // my custom fileStorage from configuration
               'multiple' => true,
               'disableCsrf' => true,
               'responseFormat' => \yii\web\Response::FORMAT_JSON,
               'responsePathParam' => 'path',
               'responseBaseUrlParam' => 'base_url',
               'responseUrlParam' => 'url',
               'responseDeleteUrlParam' => 'delete_url',
               'responseMimeTypeParam' => 'type',
               'responseNameParam' => 'name',
               'responseSizeParam' => 'size',
               'deleteRoute' => 'delete',
               'fileStorage' => 'fileStorage', // Yii::$app->get('fileStorage')
               'fileStorageParam' => 'fileStorage', // ?fileStorage=someStorageComponent
               'sessionKey' => '_uploadedFiles',
               'allowChangeFilestorage' => false,
               'validationRules' => [
                    $this->aValidationRules
               ],
               'on afterSave' => function($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    // do something (resize, add watermark etc)
               }
           ],
          'delete'=>[
             'class'=>'trntv\filekit\actions\DeleteAction',
             //'fileStorage' => 'fileStorageMy', // my custom fileStorage from configuration(such as in the upload action)
         ],
         'view'=>[
             'class'=>'trntv\filekit\actions\ViewAction',
         ]

      ];
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
    public function actionTest()
    {
        return $this->render('test');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionUpload1()
    {
        $upload_handler = new UploadHandler();
    }
}
