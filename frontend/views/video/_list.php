<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Video*/

$img=Html::img($model->thumb,['class'=>'img-responsive']);
$imglink=Html::a($img,['/video/view','id'=>$model->id],['class'=>'img-responsive rel js_des_list_img']);
?>

<div class='pull-left article-thumb mr20'>
    <?=$imglink?>
</div>

<div class="oh">
    <h3 class="mt5"><?=Html::a($model->title,['/video/view','id'=>$model->id],['class'=>'black']); ?></h3>
    <div class="color9 mt10 roboto font13">

        <time class="date"><?=Yii::$app->formatter->asDate($model->date_create)?></time>
    </div>
</div>