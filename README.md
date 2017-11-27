yii2-pms(Prevent Multiple Submissions)
========================

Prevent multiple submissions by js and php, for yii2.


Installation
------------

The preferred way to install this module is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require myzero1/yii2-pms：1.*
```

or add

```
"myzero1/yii2-pms": "~1"
```

to the require section of your `composer.json` file.



Setting
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'as PreMulSubmissions' => [
        'class' => myzero1\pms\behaviors\PreventMultipleSubmissionsBehavior::class,
        // 'excludedRoutes' => [
        //     'site/login',
        // ],
    ],
    'components' => [
    // ...
];
```

Usage
-----

You can use it,now.