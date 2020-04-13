<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?php
    $key = $model->id;
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name' => 'article']);

    $initialPreviewConfig = [];
    if (!$model->isNewRecord && $main_img = $model->image) {
        $iniImg = [Html::img("@web/images/project/" . $model->id . "/s_" . $main_img, ['class' => 'file-preview-image', 'alt' => ''])];
        $url = Url::to(['site/img-delete', 'id' => $model->id, 'model_name' => 'project']);
        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => "s_" . $main_img];
    } else {
        $iniImg = false;
    }
    echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'initialPreview' => $iniImg,
            'previewFileType' => 'any',
            'uploadUrl' => Url::to(['/site/img-upload', 'id' => $model->id]),
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>