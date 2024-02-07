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
            console.log('{$this->captchaValidateAction}')
            console.log(value)
            if (value !== 'test') {
                messages.push({$message});
            }
JS;
        return new JsExpression($js);
    }
}