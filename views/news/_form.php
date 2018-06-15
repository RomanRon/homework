<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?php if ($model->img != '') {
        echo $form->field($model, 'file')->widget(FileInput::className(), [
            'name' => 'file',
            'language' => "uk",
            'options' => [
                'multiple' => false,
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/news/uploads', 'id' => $model->id]),
                'deleteUrl' => Url::to(['/news/delete-image', 'id' => $model->id]),
                'uploadAsync' => true,
                'allowedFileExtensions' => ['png', 'jpg'],
                'showUpload' => true,
                'initialPreview' => [
                    Yii::getAlias('@web/uploads/' . $model->img),
                ],
                'uploadExtraData' => [
                    'cat_id' => 'Logo',
                    'file_id' => 1,
                ],
                'deleteExtraData' => [
                    'key' => 'update',
                    'mode' => $model->img,
                ],
                'initialPreviewAsData' => true,
            ],
        ]);
    } else {
        echo $form->field($model, 'file')->widget(FileInput::className(), [
            'name' => 'file',
            'language' => "uk",
            'options' => [
                'multiple' => false,
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/news/uploads']),
                'uploadAsync' => true,
                'allowedFileExtensions' => ['png', 'jpg'],
                'showUpload' => true,
                'uploadExtraData' => [
                    'cat_id' => 'Logo',
                    'file_id' => 1,
                ],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                'fileuploaded' => "function(event, data, previewId, index) {
                     //   $('.file-input').find('.file-footer-buttons .kv-file-remove').attr('data-file-name', data.files[0].name);
                        $('.file-input').on('click', '.kv-file-remove', function(){
                            $.ajax('" . Url::to(['/news/delete-image', 'id' => $model->id]) . "', {
                              type: 'POST',
                              data: {fileName: data.files[0].name},
                              async: false,
                              success : function (data) {
                                  $('.file-input').find('.fileinput-remove').trigger('click');
                               }
                            });
                        });          
                     }",

            ],
        ]);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success glyphicon-upload']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
