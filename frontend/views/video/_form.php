<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Video */
/* @var $form yii\widgets\ActiveForm */

$dao = Yii::$app->db;
$projects = $dao->createCommand("SELECT * FROM project")->queryAll();
$projects = ArrayHelper::map($projects, 'id', 'title');
$proj_id = $dao->createCommand("SELECT project_id FROM project_items WHERE item_id='{$model->id}' AND item='video'")->queryOne();
if ($proj_id) {
    $model->project_id = $proj_id['project_id'];
}
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?php
    if (!$model->date_create) $model->date_create = date("Y-m-d H:i");
    echo $form->field($model, 'date_create')->textInput([])
    ?>
    <?= $form->field($model, 'project_id')->dropDownList($projects, ['prompt' => Yii::t('app', 'Select') . ".."]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>