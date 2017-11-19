
<?php

$model = new \common\models\User();

echo \myzero1\yii2upload\widget\upload\Upload::widget([
    'model' => $model,
    'attribute' => 'id',
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

?>
