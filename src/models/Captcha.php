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
            // ['verifyCode','required', 'on' => 'php'],
            ['verifyCode','required', 'on' => 'jsPhp'],
            ['verifyCode',MyValidator::className(),'captchaValidateAction'=>'/captcha/default/captcha','message' => 'This field must not be "test".', 'on' => 'jsPhp'],
            // ['verifyCode', 'captcha', 'captchaAction'=>'/captcha/default/captcha', 'on' => 'jsPhp'],
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