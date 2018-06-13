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

    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'name' => 'file',
        'language' => "uk",
        'options' => [
            'multiple' => false,
        ],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/news/uploads']),
            'deleteUrl' => Url::to(['/news/delete-image']),
            'uploadAsync' => false,
            'allowedFileExtensions' => ['jpg', 'gif', 'png'],
            'showUpload' => true,
            'uploadExtraData' => [
                'cat_id' => 'Logo',
                'file_id' => 1,
            ],
            'deleteExtraData' => [
                'key' =>  'kartynka.jpg',
            ],
            'initialPreviewAsData' => true,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
