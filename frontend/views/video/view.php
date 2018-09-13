<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Video */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$width = '800px';
$height = '450px';
$src="https://www.youtube.com/embed/{$model->video_id}";
if(!$desc=$model->description){$desc=$model->title;}

$youtube_image="https://img.youtube.com/vi/{$model->video_id}/hqdefault.jpg";

Yii::$app->view->registerMetaTag(['property' => 'og:title','content' => $model->title]);
Yii::$app->view->registerMetaTag(['property' => 'og:image','content' => $youtube_image]);
Yii::$app->view->registerMetaTag(['property' => 'og:description','content' => $desc]);
Yii::$app->view->registerMetaTag(['property' => 'og:url','content' => Yii::$app->request->absoluteUrl]);
Yii::$app->view->registerMetaTag(['property' => 'fb:app_id','content' => '382095758792121']);
Yii::$app->view->registerMetaTag(['property' => 'og:type','content' => 'article']);
?>
<div class="video-view container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mb10">
        <a class="share-facebook share-icon js_fb_share" rel="nofollow" href="<?=Yii::$app->request->absoluteUrl?>" title="<?=Yii::t('app','Click to share on Facebook');?>">
            <span></span>
        </a>
        <a class="share-twitter share-icon popup" rel="nofollow" href="https://twitter.com/intent/tweet?text=<?=urlencode($model->title).'&url='.Yii::$app->request->absoluteUrl?>" data-title="Twitter" title="<?=Yii::t('app','Click to share on Twitter');?>">
            <span></span>
        </a>
        <a class="share-email share-icon" href="mailto:?subject=<?=$model->title?>&body=<?=Yii::$app->request->absoluteUrl?>" title="<?=Yii::t('app','Email this page');?>" rel="nofollow">
            <span></span>
        </a>
    </div>

    <iframe id="ytplayer" width="<?php echo $width ?>" height="<?php echo $height ?>"
            src="<?=$src ?>" frameborder="0" allowfullscreen></iframe>

    <br />
    <div class="mt10">
        <?=$model->description;?>
        <div class="mt10">
            <time class="date"><?php $time=strtotime($model->date_create); echo date("d.m.Y",$time);?></time>
        </div>
    </div>
</div>
