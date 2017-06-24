<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Opinion */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Opinions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if($model->expert_id && !empty($model->expert->title)){
    $expert_name=$model->expert->title;
    $expert_title=$model->expert->description;
    $expert_image='/images/expert/'.$model->expert_id.'/s_'.$model->expert->image;
}
else{
    $expert_name=$model->name;
    $expert_title=$model->title;
    $expert_image='/images/opinion/'.$model->id.'/s_'.$model->image;
}
if($model->url){
    $opinion_text=Html::a($model->description,$model->url);
} else{
    $opinion_text=$model->description;
}
?>
<div class="opinion-view container">
    <div class="opinion_item">
        <div class="pull-left quote_icon_wrap mr15">
            <i class="fa fa-quote-left" aria-hidden="true"></i>
        </div>
        <div class="oh">
            <div class="opinion_text mb15"><?=$opinion_text;?></div>
            <div class="opinion_author">
                <div class="opinion_author_img pull-left mr15"><?=Html::img($expert_image,['class'=>'round author_image_small'])?></div>
                <div class="opinion_author_name">
                    <div class="bold"><?=$expert_name?></div>
                    <span class='font12 color69'><?=$expert_title?></span>
                </div>
            </div>
        </div>
    </div>


</div>
