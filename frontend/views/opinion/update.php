<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Opinion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Opinion',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Opinions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="opinion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
