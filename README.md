yii2-captcha
========================

You can upload file,Just a add a widget to view.


Installation
------------

The preferred way to install this module is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require myzero1/yii2-upload：1.*
```

or add

```
"myzero1/yii2-upload": "~1"
```

to the require section of your `composer.json` file.



Setting
-----

Once the module is installed, simply modify your application configuration as follows:

```php
return [
    'modules' => [
        'upload' => [
            'class' => 'myzero1\yii2upload\Tools',
            'upload' => [
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
            ],
        ],
        // ...
    ],
    // ...
];
```

Usage
-----

Add upload widget like following:

```

echo \myzero1\yii2upload\widget\upload\Upload::widget([
    'model' => $model,
    'attribute' => 'logo',
    // 'url' => ['/tools/upload/upload'], // default ['/tools/upload/upload'],
    // 'sortable' => true,
    // 'maxFileSize' => 200  * 1024, // 200k
    // 'minFileSize' => 1 * 1024, // 1k
    // 'maxNumberOfFiles' => 1, // default 1,
    // 'acceptFileTypesNew' => [], // default ['gif','jpeg','jpg','png'],
    // 'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),// if it is null，the acceptFileTypesNew will working.
    // 'showPreviewFilename' => false,
    // 'clientOptions' => []
]);


```

With ActiveForm

```

echo $form->field($model, 'logo')->widget(
    '\myzero1\yii2upload\widget\upload\Upload',
    [
        // 'url' => ['/tools/upload/upload'], // default ['/tools/upload/upload'],
        // 'sortable' => true,
        // 'maxFileSize' => 200  * 1024, // 200k
        // 'minFileSize' => 1 * 1024, // 1k
        // 'maxNumberOfFiles' => 1, // default 1,
        // 'acceptFileTypesNew' => [], // default ['gif','jpeg','jpg','png'],
        // 'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),// if it is null，the acceptFileTypesNew will working.
        // 'showPreviewFilename' => false,
        // 'clientOptions' => []
    ]
);


```

You can then access Upload testing through the following URL:

```
http://localhost/path/to/index.php?r=upload/upload/test
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/upload/upload/test
```
