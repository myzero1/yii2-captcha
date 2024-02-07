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
            ['verifyCode','required', 'on' => 'jsPhp'],
            ['verifyCode',MyValidator::className(),'captchaValidateAction'=>'/captcha/default/captcha-validate','message' => '验证码错误', 'on' => 'jsPhp'],
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