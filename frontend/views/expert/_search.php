<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ExpertSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expert-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'expertise_areas') ?>

    <?php // echo $form->field($model, 'current_positions') ?>

    <?php // echo $form->field($model, 'past_positions') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'cv') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
