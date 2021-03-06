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
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model) {
                    return [
                        'checked' => $model->public,
                        'class'=>'js_approve_comment',
                        'data-id'=>$model->id,
                    ];
                },
                'header' => 'Публичный',
                'contentOptions' => ['class' => 'text-center'],
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
