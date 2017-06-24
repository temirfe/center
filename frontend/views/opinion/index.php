<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OpinionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Opinions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="opinion-index container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Opinion'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'title',
            'description',
            'image',
            'expert_id',
            [
                'attribute' => 'expert_id',
                'format' => 'raw',
                'value' => function($model) {
                    if($model->expert_id && !empty($model->expert->title)){
                        $expert_title=$model->expert->title;
                    }
                    else{
                        $expert_title="";
                    }
                    return $expert_title;
                },
                'contentOptions'=>['width'=>180]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
