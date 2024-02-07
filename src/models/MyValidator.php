<?php
namespace myzero1\captcha\models;

use yii\validators\Validator;
use yii\web\JsExpression;

class MyValidator extends Validator
{
    public $captchaValidateAction;

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $js = <<<JS
            var value = $('input[name="{$model->formName()}[{$attribute}]"]').val();

            if (window.z1CaptchaValidate!=undefined) {
                console.log('window.z1CaptchaValidate',window.z1CaptchaValidate)
                if (window.z1CaptchaValidate!=1) {
                    messages.push({$message})
                }
                window.z1CaptchaValidate=undefined
            } else {
                messages.push('请先确认验证码正确')
                $.ajax({
                    url: '{$this->captchaValidateAction}',
                    type: 'GET',
                    data: {
                        code: value
                    },
                    success: function(response) {
                        // 处理成功响应
                        window.z1CaptchaValidate=response

                        $('input[name="{$model->formName()}[{$attribute}]"]').focus()
                        $('input[name="{$model->formName()}[{$attribute}]"]').blur()
                    },
                    error: function(xhr, status, error) {
                        // 处理错误响应
                        window.z1CaptchaValidate=error
                        
                        $('input[name="{$model->formName()}[{$attribute}]"]').focus()
                        $('input[name="{$model->formName()}[{$attribute}]"]').blur()
                    }
                });
            }

JS;
        return new JsExpression($js);
    }
}