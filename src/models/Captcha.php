<?php
namespace myzero1\captcha\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Captcha extends Model
{
    public $verifyCode;
    public $test;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['test','required'],
            ['verifyCode', 'captcha', 'captchaAction'=>'/captcha/default/captcha'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('app', '验证码'),
        ];
    }

}
