<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExpertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Media').' | '.Yii::t('app','CPLR');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index large-container">

    <h1><?= Yii::t('app', 'Media') ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'emptyText' => Yii::t('app', 'No results found'),
        'summary'=>'',
        'options'=>['class'=>'item-view'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_list',['model' => $model]);
        },
    ]) ?>
</div>
