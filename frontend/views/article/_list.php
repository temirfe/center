<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article*/
if($model->image){
    $img=Html::img("/images/article/".$model->id."/s_".$model->image,['class'=>'img-responsive']);
}
else $img="<div class='no_img text-center'>".Html::img("/images/logo_simple.png",['class'=>'slider'])."</div>";
$imglink=Html::a($img,['/article/view','id'=>$model->id],['class'=>'img-responsive rel js_des_list_img']);
?>

<div class='pull-left article-thumb mr20'>
    <?=$imglink?>
</div>

<div class="oh">
    <div class="text-uppercase bold blue font12"><?=$model->getLangTitle()?></div>
    <h3 class="mt5"><?=Html::a($model->title,['/article/view','id'=>$model->id],['class'=>'black']); ?></h3>
    <div class="color9 mt10 roboto font13">
        <?php
        if($authors=$model->getAuthors()){
            ?>
            <div class='afterdot pull-left'><?=$authors?></div>
        <?php
        }
        ?>

        <time class="date"><?php $time=strtotime($model->date_create); echo date("d.m.Y",$time);?></time>
    </div>
</div>