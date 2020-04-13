<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use \yii\helpers\ArrayHelper;
use vova07\imperavi\Widget as ImperaviWidget;
use frontend\assets\SpecialcharsAsset;

/*$kcfOptions = array_merge(KCFinder::$kcfDefaultOptions, [
    'disabled' => false,
    'uploadUrl' => '/upload3',
    'uploadDir' => Yii::getAlias('@webroot').'/upload3',
]);

// Set kcfinder session options
Yii::$app->session->set('KCFINDER', $kcfOptions);*/

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */
/* @var $form yii\widgets\ActiveForm */

$dao = Yii::$app->db;
$categories = $dao->createCommand("SELECT * FROM category")->queryAll();
$categories = ArrayHelper::map($categories, 'id', 'title');
$experts = $dao->createCommand("SELECT * FROM expert ORDER BY title")->queryAll();
$experts = ArrayHelper::map($experts, 'id', 'title');
$projects = $dao->createCommand("SELECT * FROM project")->queryAll();
$projects = ArrayHelper::map($projects, 'id', 'title');

$proj_id = $dao->createCommand("SELECT project_id FROM project_items WHERE item_id='{$model->id}' AND item='article'")->queryOne();
if ($proj_id) {
    $model->project_id = $proj_id['project_id'];
}
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    $key = $model->id;
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name' => 'article']);

    $initialPreviewConfig = [];
    if (!$model->isNewRecord && $main_img = $model->image) {
        $iniImg = [Html::img("@web/images/article/" . $model->id . "/s_" . $main_img, ['class' => 'file-preview-image', 'alt' => ''])];
        $url = Url::to(['site/img-delete', 'id' => $model->id, 'model_name' => 'article']);
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

    <?php
    echo $form->field($model, 'text')->widget(ImperaviWidget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'maxHeight' => 400,
            'imageUpload' => Url::to(['/site/image-upload']),
            'imageManagerJson' => Url::to(['/site/images-get']),
            'pastePlainText' => true,
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'table',
                //'specialchars'
            ],
        ],
        'plugins' => [
            'specialchars' => 'frontend\assets\SpecialcharsAsset'
        ],
    ]);
    ?>



    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => Yii::t('app', 'Select') . ".."]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'project_id')->dropDownList($projects, ['prompt' => Yii::t('app', 'Select') . ".."]) ?></div>
        <div class="col-sm-2 mt20 pt10"><?= $form->field($model, 'own')->checkbox(); ?></div>
    </div>

    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'expert_id')->dropDownList($experts, ['prompt' => "Select.."]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'expert2_id')->dropDownList($experts, ['prompt' => "Select.."]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'expert3_id')->dropDownList($experts, ['prompt' => "Select.."]) ?></div>
    </div>

    <?= $form->field($model, 'custom_author')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'footnotes')->textInput(['maxlength' => true]) ?>

    <?php
    $model_name = "article";
    $url = Url::to(['site/file-delete', 'id' => $model->id, 'model_name' => $model_name]);
    $iniCv = false;
    if (!$model->isNewRecord) {
        $dir = "files/" . $model_name . "/" . $model->id;
        if (is_dir($dir)) {
            $imgs = scandir($dir);
            foreach ($imgs as $img) {
                if ($img != '.' && $img != '..') {
                    $iniCv[] = [
                        "<div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2>" . Html::a($img, '/' . $dir . "/" . $img, ['class' => 'file-preview-text']) . "</div>"
                    ];
                    $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => $img];
                }
            }
        }
    }

    echo $form->field($model, 'docFiles[]')->widget(FileInput::classname(), [
        'options' => ['multiple' => true],
        'language' => 'ru',
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'overwriteInitial' => false,
            'initialPreview' => $iniCv,
            'allowedFileExtensions' => ['doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx'],
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>