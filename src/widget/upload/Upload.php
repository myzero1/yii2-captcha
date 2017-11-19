<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace myzero1\yii2upload\widget\upload;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\InputWidget;

/**
 * Class Upload
 * @package trntv\filekit\widget
 */
class Upload extends InputWidget
{
    /**
     * @var
     */
    public $files;
    /**
     * @var array|\ArrayObject
     */
    public $url;
    /**
     * @var array
     */
    public $clientOptions = [];
    /**
     * @var bool
     */
    public $showPreviewFilename = false;
    /**
     * @var bool
     */
    public $multiple = false;
    /**
     * @var bool
     */
    public $sortable = false;
    /**
     * @var int min file size in bytes
     */
    public $minFileSize;
    /**
     * @var int
     */
    public $maxNumberOfFiles = 1;
    /**
     * @var int max file size in bytes
     */
    public $maxFileSize;
    /**
     * @var string regexp
     */
    public $acceptFileTypes;
    /**
     * @var array
     */
    public $acceptFileTypesNew;
    /**
     * @var string
     */
    public $messagesCategory = 'myzero1\yii2upload';
    /**
     * @var bool preview image file or not in the upload box.
     */
    public $previewImage = true;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->registerMessages();



        if (!$this->maxNumberOfFiles) {
            $this->maxNumberOfFiles = 1;
        }
        if (!$this->url) {
            foreach (Yii::$app->getModules() as $key => $mModule) {
                if (is_array($mModule)) {
                    if (trim($mModule['class'], '\\') == 'myzero1\yii2upload\Tools') {
                        $moduleId = $key;
                    }
                } else {
                    if (trim($mModule::className(), '\\') == 'myzero1\yii2upload\Tools') {
                        $moduleId = $mModule->id;
                    }
                }
            }
            if (isset($moduleId)) {
                $this->url = ["/$moduleId/upload/upload"];
            } else {
                var_dump('请在项目配置文件中，配置yii2-upload模块');exit;
            }
        }
        if (!$this->maxFileSize) {
            $this->maxFileSize = 200 * 1024;
        }
        if (!$this->minFileSize) {
            $this->minFileSize = 1 * 1024;
        }
        if (!$this->acceptFileTypesNew) {
            $this->acceptFileTypesNew = ['gif','jpeg','jpg','png'];
        }
        if ($this->maxNumberOfFiles > 1 || $this->multiple) {
            $this->multiple = true;
        }
        if ($this->hasModel()) {
            $this->name = $this->name ?: Html::getInputName($this->model, $this->attribute);
            $this->value = $this->value ?: Html::getAttributeValue($this->model, $this->attribute);
        }
        if (!array_key_exists('name', $this->clientOptions)) {
            $this->clientOptions['name'] = $this->name;
        }
        if ($this->multiple && $this->value && !is_array($this->value)) {
            throw new InvalidParamException('In "multiple" mode, value must be an array.');
        }
        if (!array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->getFileInputName();
            $md5Tem = md5(time());
            $this->url['uploadhash'] = $md5Tem;
            $validationRules = [
                'extensions' => $this->acceptFileTypesNew,
                'maxSize' => $this->maxFileSize, //10 * 1024 * 1024, // 10Mb
                'minSize' => $this->minFileSize, // 1Mb
            ];
            \Yii::$app->session->set($md5Tem, \yii\helpers\Json::encode($validationRules));
        }
        if (!$this->files && $this->value) {
            if (is_string($this->value)) {
                $parseUrl = explode('/', $this->value);
                $file = array();
                $file['name'] = array_pop($parseUrl);
                $tmp = array_pop($parseUrl);
                $file['path'] = sprintf('%s/%s',$tmp, $file['name']);
                $file['base_url'] = implode('/', $parseUrl);
                $file['url'] = $this->value;

                $this->value = $file;

            } else {
                # code...
            }

            $this->files = $this->multiple ? $this->value : [$this->value];
        }
        if (!$this->acceptFileTypes) {
            $regexp = sprintf('/(\.|\/)(%s)$/i',implode('|', $this->acceptFileTypesNew));
            $acceptFileTypes = new \yii\web\JsExpression($regexp);
        }

        $classNS = explode('\\', get_class($this->model));
        $className = array_pop($classNS);
        $targetId = sprintf('%s-%s', strtolower($className), $this->attribute);

        $this->clientOptions = ArrayHelper::merge(
            [
                'url' => Url::to($this->url),
                'multiple' => $this->multiple,
                'sortable' => $this->sortable,
                'maxNumberOfFiles' => $this->maxNumberOfFiles,
                'maxFileSize' => $this->maxFileSize,
                'minFileSize' => $this->minFileSize,
                'acceptFileTypes' => $acceptFileTypes,
                'files' => $this->files,
                'previewImage' => $this->previewImage,
                'showPreviewFilename' => $this->showPreviewFilename,
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'pathAttributeName' => 'path',
                'baseUrlAttributeName' => 'base_url',
                'messages' => [
                    'maxNumberOfFiles' => Yii::t($this->messagesCategory, 'Maximum number of files exceeded'),
                    'acceptFileTypes' => Yii::t($this->messagesCategory, 'File type not allowed'),
                    'maxFileSize' => Yii::t($this->messagesCategory, 'File is too large'),
                    'minFileSize' => Yii::t($this->messagesCategory, 'File is too small')
                ],
                'done' => new \yii\web\JsExpression('function(e, data) {
                    console.log(data);
                    if ("result" in data && "files" in data["result"]) {
                        setTimeout(function(){
                            $("#'.$targetId.'").val(data["result"]["files"][0]["url"]);
                        },500);
                    } else if ("_response" in data && "result" in data["_response"] && "files" in data["_response"]["result"]) {
                        $("#'.$targetId.'").val(data["_response"]["result"]["files"][0]["url"]);
                    }

                    $(".upload-kit .upload-kit-item input[type=hidden]").remove();

                 }'),
                'always' => new \yii\web\JsExpression('function(e, data) {
                    console.log("+++");
                 }'),
            ],
            $this->clientOptions
        );
    }

    /**
     * @return void Registers widget translations
     */
    protected function registerMessages()
    {
        if (!array_key_exists($this->messagesCategory, Yii::$app->i18n->translations)) {
            Yii::$app->i18n->translations[$this->messagesCategory] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
                'fileMap' => [
                    $this->messagesCategory => 'filekit/widget.php'
                ],
            ];
        }
    }

    /**
     * @return string
     */
    public function getFileInputName()
    {
        return sprintf('_fileinput_%s', $this->id);
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $content = Html::beginTag('div');
        $content .= Html::hiddenInput($this->name, null, [
            'class' => 'empty-value',
            'id' => $this->options['id']
        ]);
        $content .= Html::fileInput($this->getFileInputName(), null, [
            'name' => $this->getFileInputName(),
            'id' => $this->getId(),
            'multiple' => $this->multiple
        ]);
        $content .= Html::endTag('div');
        return $content;
    }

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        UploadAsset::register($this->getView());
        $options = Json::encode($this->clientOptions);
        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }
        $this->getView()->registerJs("jQuery('#{$this->getId()}').yiiUploadKit({$options});");
    }
}
