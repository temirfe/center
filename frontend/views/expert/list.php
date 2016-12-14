<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExpertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Experts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-md-4 mb15'],
        'emptyText' => Yii::t('app', 'No results found'),
        'summary'=>'',
        'options'=>['class'=>'item-view row'],
        'itemView' => function ($model, $key, $index, $widget) {
            $html="<div class='mb20 oh'>";
            if($model->image)
                $img=Html::img("/images/expert/".$model->id."/s_".$model->image,['class'=>'round author_image_small']);
            else {
                $words = explode(" ", $model->title);
                $acronym = "";

                foreach ($words as $w) {
                    $acronym .= mb_substr($w, 0, 1);
                }
                $img="<div class='round initials_thumb'>".$acronym."</div>";
            }
            $url=Html::a($img,['/expert/view','id'=>$model->id]);
            $author=Html::a($model->title,['/expert/view','id'=>$model->id],['class'=>'darklink']);
            $html.="<div class='pull-left mr15'>".$url."</div>";
            $html.="<h2 class='name'>".$author.'</h2>';
            $html.="<span class='font12 color69'>".$model->description."</span>";
            $html.="</div>";

            return $html;
        },
    ]) ?>
</div>
