<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Opinion */

$this->title = Yii::t('app', 'Create Opinion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Opinions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="opinion-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
