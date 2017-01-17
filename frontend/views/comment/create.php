<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Comment */

$this->title = Yii::t('app', 'Create Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
