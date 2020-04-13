<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExpertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles') . ' | ' . Yii::t('app', 'CPLR');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-index container">

    <h1><?= Yii::t('app', 'Articles') ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'emptyText' => Yii::t('app', 'No results found'),
        'summary' => '',
        'options' => ['class' => 'item-view'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_list', ['model' => $model]);
        },
    ]) ?>
</div>