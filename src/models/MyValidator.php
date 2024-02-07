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
            var ing='验证中...'

            if (window.z1CaptchaValidate!=undefined) {
                // console.log('window.z1CaptchaValidate',window.z1CaptchaValidate)
                if (window.z1CaptchaValidate!=1) {
                    messages.push({$message})
                }
                window.z1CaptchaValidate=undefined
            } else {
                messages.push(ing)

                setInterval(() => {
                    var next=$('input[name="{$model->formName()}[{$attribute}]"]').next()
                    if (next.length>0 && next.text()==ing) {
                        $('input[name="{$model->formName()}[{$attribute}]"]').focus()
                        $('input[name="{$model->formName()}[{$attribute}]"]').blur()
                    }
                }, 1000);

                $.ajax({
                    url: '{$this->captchaValidateAction}',
                    type: 'GET',
                    data: {
                        code: value
                    },
                    success: function(response) {
                        // 处理成功响应
                        window.z1CaptchaValidate=response
                    },
                    error: function(xhr, status, error) {
                        // 处理错误响应
                        window.z1CaptchaValidate=error
                    }
                });
            }

JS;
        return new JsExpression($js);
    }
}