yii2-captcha
========================

Simple captcha for yii2.Just add the module in config file and use the widget.


Installation
------------

The preferred way to install this module is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require myzero1/yii2-captcha：1.*
```

or add

```
"myzero1/yii2-captcha": "~1"
```

to the require section of your `composer.json` file.



Setting
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
	// ...
    'bootstrap' => ['captcha',...],
    'modules' => [
        'captcha' => [
            'class' => 'myzero1\captcha\Module',
            // 'maxLen' => 4, //最大显示个数
            // 'minLen' => 4, //最少显示个数
            // 'timeout' => 300, //过期时间，单位为秒
            // 'key' => 'myzero1自研', //用于验证码加密
            // 'source' => '0123456789abcdefghijklmnopqrstuvwxyz', //候选字符，不支持中文的图片渲染，但支持生成中文验证码
            // 'width' => 130,  //宽度
            // 'height' => 32, //高度
            // 'bgColor' => '#dddddd', //背景颜色,六位的rgb
            // 'fontSize' => 24, //字体大小,最大值是 5,这个值对应于 14 像素的字体大小,越大字间距越大
            // 'startLeftTopPoint' => [10,5], //字符起点的左上角坐标
            // 'noiseSpot' => 50, //干扰点数量
            // 'noiseLine' => 3, //干扰线数量
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

echo \myzero1\captcha\widgets\Captcha::widget([
    'model' => new \myzero1\captcha\models\Captcha(['scenario'=>'js']),
    // 'model' => new \myzero1\captcha\models\Captcha(['scenario'=>'jsPhp']),
    'attribute' => 'verifyCode',
    'imageOptions'=>[
        'alt'=>'点击换图',
        'title'=>'点击换图',
        'style'=>'cursor:pointer'
    ]
]);


```

With ActiveForm

```

echo  $form
// ->field(new \myzero1\captcha\models\Captcha(['scenario'=>'php']),'verifyCode')
->field(new \myzero1\captcha\models\Captcha(['scenario'=>'jsPhp']),'verifyCode')
->widget(
    myzero1\captcha\widgets\Captcha::className(),
    [
        'imageOptions'=>[
            'alt'=>'点击换图',
            'title'=>'点击换图',
            'style'=>'cursor:pointer'
        ]
    ]
)


```

The scenario discretion
- php: Just validate by PHP.
- jsPhp: validate by JS and PHP

You can access Demo through the following URL:

```
http://localhost/path/to/index.php?r=captcha/default/demo
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/captcha/default/demo
```
