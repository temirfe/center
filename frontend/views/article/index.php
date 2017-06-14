<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
$rows=Yii::$app->db->createCommand("SELECT id, title FROM category")->queryAll();
$ctg=ArrayHelper::map($rows,'id','title');
?>
<div class="article-index container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            'title',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img('/images/article/'.$model->id.'/s_'.$model->image,['class'=>'w100']);
                },
                'contentOptions'=>['width'=>180]
            ],
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                /*'value' => function($model) use($ctg) {
                    return $ctg[$model->category_id];
                },*/
                'filter' => Html::activeDropDownList($searchModel, 'category_id', $ctg,['class'=>'form-control','prompt' => Yii::t('app','All')]),
                'contentOptions'=>['width'=>180]
            ],
            // 'expert_id',
             'date_create',
            // 'footnotes',
            ['attribute' => 'views', 'contentOptions'=>['width'=>130]],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
