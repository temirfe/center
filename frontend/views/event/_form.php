<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Event */
/* @var $form yii\widgets\ActiveForm */

$dao = Yii::$app->db;
$experts = $dao->createCommand("SELECT * FROM expert ORDER BY title")->queryAll();
$experts = ArrayHelper::map($experts, 'id', 'title');

$participants = $dao->createCommand("SELECT expert_id FROM participant WHERE model_id='{$model->id}' AND model_name='event'")->queryAll();


$projects = $dao->createCommand("SELECT * FROM project")->queryAll();
$projects = ArrayHelper::map($projects, 'id', 'title');
$proj_id = $dao->createCommand("SELECT project_id FROM project_items WHERE item_id='{$model->id}' AND item='event'")->queryOne();
if ($proj_id) {
    $model->project_id = $proj_id['project_id'];
}
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions' => [
            'allowedContent' => true,
            //'extraAllowedContent'=>'span(*);div(*)[*]{*};h2(*)',
            /*'enterMode' => 2,
            'forceEnterMode'=>false,
            'shiftEnterMode'=>1,*/
            'toolbar' => [ //toolbar names can be found here: http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
                ['name' => 'document', 'items' => ['Source']],
                ['name' => 'basicstyles', 'items' => ['Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', '-', 'RemoveFormat']],
                ['name' => 'Clipboard', 'items' => ['Paste', 'PasteText', 'PasteFromWord']],
                ['name' => 'insert', 'items' => ['Image', 'Table', 'HorizontalRule']],
                ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']],
                ['name' => 'links', 'items' => ['Link', 'Unlink']],
                ['name' => 'styles', 'items' => ['Styles', 'Format', 'Font', 'FontSize']],
                ['name' => 'tools', 'items' => ['Maximize']],
            ]
        ]
    ]) ?>

    <?php
    $key = $model->id;
    $model_name = 'event';
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name' => $model_name]);

    $initialPreviewConfig = [];
    if (!$model->isNewRecord && $main_img = $model->image) {
        $iniImg = [Html::img("@web/images/" . $model_name . "/" . $model->id . "/s_" . $main_img, ['class' => 'file-preview-image', 'alt' => ''])];
        $url = Url::to(['site/img-delete', 'id' => $model->id, 'model_name' => $model_name]);
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

    <div class="row mb20 mt20">
        <div class="col-md-4">
            <?php
            echo DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'date_start',
                'options' => ['placeholder' => Yii::t('app', 'Start date')],
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'date_end',
                'options' => ['placeholder' => Yii::t('app', 'End date')],
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>
    </div>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latlong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hosted_by')->textInput(['maxlength' => true]) ?>

    <div class="js_panelists">
        <?php
        if ($participants) {
            foreach ($participants as $key => $pa) {
                $model->panelist[$key] = $pa['expert_id'];
                echo $form->field($model, "panelist[$key]")->dropDownList($experts, ['prompt' => Yii::t('app', 'Select') . ".."]);
            }
        }
        ?>
    </div>
    <?= Html::a(Yii::t('app', 'Add panelist'), '#', ['class' => 'js_add_panelist mb20 iblock']); ?>

    <?= $form->field($model, 'project_id')->dropDownList($projects, ['prompt' => Yii::t('app', 'Select') . ".."]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="js_panelist_form hidden"><?= $form->field($model, 'panelist[]')->dropDownList($experts, ['prompt' => Yii::t('app', 'Select') . ".."]) ?></div>