<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>70]],
            'name',
            'content',
            //'user_id',
            [
                'header' => 'Статья',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->article->title,'/'.$model->model_name.'/'.$model->model_id);
                },
            ],
            [
                'attribute' => 'public',
                'format' => 'raw',
                'value' => function($model) {
                    if($model->public) $public="да"; else $public="нет";
                    return $public;
                },
                'contentOptions'=>['width'=>80]
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
