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

            // console.log(messages)
            messages.pop()
            messages.push(ing)

            $.ajax({
                url: '{$this->captchaValidateAction}',
                type: 'GET',
                async: false, // 设置为同步请求
                data: {
                    code: value
                },
                success: function(response) {
                    // 处理成功响应
                    if (response!=1) {
                        messages.pop()
                        messages.push({$message})
                    } else {
                        messages.pop()
                        messages.pop()
                    }
                },
                error: function(xhr, status, error) {
                    // 处理错误响应
                    messages.pop()
                    messages.push('xhr err')
                    console.log(error)
                }
            });
JS;
        return new JsExpression($js);
    }
}
