<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Opinion */
/* @var $form yii\widgets\ActiveForm */

$experts=Yii::$app->db->createCommand("SELECT * FROM expert ORDER BY title")->queryAll();
$experts=ArrayHelper::map($experts,'id','title');
if($model->expert_id){$hidden='hiddeniraak';}else{$hidden='';}
?>

<div class="opinion-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?php
        echo $form->field($model, "expert_id")->dropDownList($experts,['prompt'=>Yii::t('app','Select')."..", 'class'=>'form-control js_select_expert_for_opinion']);
    ?>
    <div class="js_opinionist <?=$hidden;?>">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?php
        $key = $model->id;
        $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>'opinion']);

        $initialPreviewConfig =[];
        if(!$model->isNewRecord && $main_img=$model->image) {
            $iniImg=[Html::img("@web/images/opinion/".$model->id."/s_".$main_img, ['class'=>'file-preview-image', 'alt'=>''])];
            $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>'opinion']);
            $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => "s_".$main_img];
        }
        else {
            $iniImg=false;
        }
        echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'initialPreview'=>$iniImg,
                'previewFileType' => 'any',
                'uploadUrl' => Url::to(['/site/img-upload','id'=>$model->id]),
                'initialPreviewConfig' => $initialPreviewConfig,
            ],
        ]);

        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
