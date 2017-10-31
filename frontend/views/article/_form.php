<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */
/* @var $form yii\widgets\ActiveForm */
$categories=Yii::$app->db->createCommand("SELECT * FROM category")->queryAll();
$categories=ArrayHelper::map($categories,'id','title');
$experts=Yii::$app->db->createCommand("SELECT * FROM expert ORDER BY title")->queryAll();
$experts=ArrayHelper::map($experts,'id','title');
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    $key = $model->id;
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>'article']);

    $initialPreviewConfig =[];
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/article/".$model->id."/s_".$main_img, ['class'=>'file-preview-image', 'alt'=>''])];
        $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>'article']);
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

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions'=>[
            'allowedContent'=>true,
            'forcePasteAsPlainText'=>true,
            //'extraAllowedContent'=>'span(*);div(*)[*]{*};h2(*)',
            /*'enterMode' => 2,
            'forceEnterMode'=>false,
            'shiftEnterMode'=>1,*/
            /*'toolbar'=>[ //toolbar names can be found here: http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
                ['name'=>'document','items'=>['Source']],
                ['name'=>'basicstyles','items'=>['Bold','Italic','Underline','Strike','-','TextColor','BGColor','-','RemoveFormat']],
                ['name'=>'Clipboard','items'=>['Paste','PasteText','PasteFromWord']],
                ['name'=>'insert','items'=>['Image','Table','HorizontalRule']],
                ['name'=>'paragraph','items'=>['NumberedList','BulletedList','-','Outdent','Indent']],
                ['name'=>'links','items'=>['Link','Unlink']],
                ['name'=>'styles','items'=>['Styles','Format','Font','FontSize']],
                ['name'=>'tools','items'=>['Maximize']],
            ]*/
        ]
    ]) ?>

    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'category_id')->dropDownList($categories,['prompt'=>Yii::t('app','Select').".."]) ?></div>
        <div class="col-sm-2 mt20 pt10"><?= $form->field($model, 'own')->checkbox(); ?></div>
    </div>

    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'expert_id')->dropDownList($experts,['prompt'=>"Select.."]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'expert2_id')->dropDownList($experts,['prompt'=>"Select.."]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'expert3_id')->dropDownList($experts,['prompt'=>"Select.."]) ?></div>
    </div>

    <?= $form->field($model, 'custom_author')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'footnotes')->textInput(['maxlength' => true]) ?>

    <?php
    $model_name="article";
    $url = Url::to(['site/file-delete', 'id' => $model->id, 'model_name'=>$model_name]);
    $iniCv=false;
    if(!$model->isNewRecord) {
        $dir="files/".$model_name."/".$model->id;
        if(is_dir($dir)){
            $imgs=scandir($dir);
            foreach($imgs as $img){
                if($img!='.' && $img!='..'){
                    $iniCv[]=[
                        "<div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2>".Html::a($img,'/'.$dir."/".$img, ['class'=>'file-preview-text'])."</div>"
                    ];
                    $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => $img];
                }
            }
        }
    }

    echo $form->field($model, 'docFiles[]')->widget(FileInput::classname(), [
        'options' => ['multiple'=>true],
        'language' => 'ru',
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'overwriteInitial'=>false,
            'initialPreview'=>$iniCv,
            'allowedFileExtensions'=>['doc','docx','rtf','pdf','xls','xlsx'],
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
