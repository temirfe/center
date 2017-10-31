<?php

/* @var $this yii\web\View */
/* @var $opinion frontend\models\Opinion */
use yii\helpers\Html;
use frontend\models\Article;
use frontend\models\Event;
use frontend\models\Video;
use frontend\models\Opinion;
use yii\caching\DbDependency;
use frontend\assets\BxSliderAsset;


BxSliderAsset::register($this);

//$this->title = 'Центр политико-правовых исследований';
$this->title = Yii::t('app','CPLR | Center for political and legal research');
$dao=Yii::$app->db;

$dep = new DbDependency();
$dep->sql = 'SELECT MAX(last_update) FROM depend WHERE table_name="article"';

$owns = $dao->cache(function ($dao) {
    return Article::find()->where("own=1")->orderBy('id DESC')->limit(5)->all();
}, 30600, $dep);
$articles = $dao->cache(function ($dao) {
    return Article::find()->select('id,title')->where("own=0")->orderBy('id DESC')->limit(5)->all();
}, 30600, $dep);
$top_articles = $dao->cache(function ($dao) {
    return Article::find()->select('id,title,views')->orderBy('views DESC')->limit(5)->all();
}, 30600, $dep);

$events=Event::find()->where('date_end>NOW()')->orderBy('id DESC')->limit(2)->all();
$videos=Video::find()->orderBy('id DESC')->limit(4)->all();
$opinions=Opinion::find()->orderBy('id DESC')->limit(4)->all();
?>

<div class="site-index large-container oh pb20">
    <div class="top_content mt10">
        <div class="bxslider_wrap">
            <ul class="bxslider">
                <?php
                foreach ($owns as $article){
                    echo "<li><a href='article/{$article->id}'><img class='bximg' src='/images/article/{$article->id}/m_{$article->image}' title='<a href=\"article/{$article->id}\">{$article->title}</a>' /></a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="headlights">
            <?php
            if($owns){
                //echo "<h3 class='roboto mb15 navy font19 bbthinblue pb5'>".Yii::t('app','Center Articles')."</h3>";
                foreach ($owns as $si=>$article){
                    if($si==0){$bge6="bge6";}else{$bge6="";}
                    ?>
                    <div class="oh pad10 rel js_sindex js_slide_index_<?=$si?> <?=$bge6?>" data-index="<?=$si?>" rel>
                        <div class="oh">
                            <?=Html::a($article->title."<span class='false_link'></span>",['/article/view','id'=>$article->id],['class'=>'black own_title roboto font16 no_underline']); ?>
                            <div class="color9 mt2 roboto font13">
                                <?php if($authors=$article->getAuthors()){
                                    ?>
                                    <div class='afterdot pull-left'><?=$authors?></div>
                                    <?php
                                } ?>
                                <time class="date"><?php $time=strtotime($article->date_create); echo date("d.m.Y",$time);?></time>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="clear"></div>
    <br />
    <div class="body-content mt15">
        <h3 class="roboto mb15 navy font19 bbthinblue pb5"><?=Yii::t('app','Media')?></h3>
        <div class="video_thumbs">
            <?php
            foreach($videos as $video){
                $vimg=Html::img($video->thumb,['class'=>'img-responsive']);
                echo "<div class='vthumb mb20 rel'>"
                    .Html::a($vimg.$video->title,['/video/view','id'=>$video->id],['class'=>'', 'data-id'=>$video->video_id])
                    ."<span class='abs tube iblock'></span></span></div>";
            }
            ?>
        </div>
        <div class="clear"></div>
        <br />

        <?php if($opinions){

        echo "<h3 class='roboto mb15 navy font19 bbthinblue pb5'>".Yii::t('app','Opinions')."</h3>";
            foreach($opinions as $opinion){
                if($opinion->expert_id && !empty($opinion->expert->title)){
                    $expert_name=$opinion->expert->title;
                    $expert_title=$opinion->expert->description;
                    $expert_image='/images/expert/'.$opinion->expert_id.'/s_'.$opinion->expert->image;
                }
                else{
                    $expert_name=$opinion->name;
                    $expert_title=$opinion->title;
                    $expert_image='/images/opinion/'.$opinion->id.'/s_'.$opinion->image;
                }

                if($opinion->url){
                    $opinion_text=Html::a($opinion->description,$opinion->url);
                } else{
                    $opinion_text=$opinion->description;
                }
                ?>
                <div class="opinion_item pull-left mb20">
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
        <?php
            }
            echo "<div class=\"clear\"></div><br />";
        } ?>

        <div class="col-md-4 oh">
            <?php
            if(!empty($articles)){
                echo "<h3 class='roboto mb15 navy font19 bbthinblue pb5'>".Yii::t('app','Interesting materials')."</h3>";
                foreach($articles as $art){
                    echo Html::a("<span class='mr4 block pull-left'>—</span><span class='oh block'>".$art->title."</span>",['/article/view','id'=>$art->id],['class'=>'mb5 iblock color3 roboto no_underline w100']);
                }
            }
            ?>
        </div>
        <?php
        /*if($events){
            */?><!--
            <div class="col-md-4 oh">

                <h3 class='roboto mb15 navy font19 bbthinblue mb20 pb5'><?/*=Yii::t('app','Events')*/?></h3>
                <?php
/*                foreach($events as $event){
                    echo "<div class='mb20 oh'>".$this->render('/event/_list',['model' => $event])."</div>";
                }
                */?>
            </div>
        --><?php
/*        }*/
        ?>


        <div class="col-md-4 oh fb_box">
            <div class="fb-page" data-href="https://www.facebook.com/%D0%A6%D0%B5%D0%BD%D1%82%D1%80-%D0%BF%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%BE-%D0%BF%D1%80%D0%B0%D0%B2%D0%BE%D0%B2%D1%8B%D1%85-%D0%B8%D1%81%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9-232160823883163/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/%D0%A6%D0%B5%D0%BD%D1%82%D1%80-%D0%BF%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%BE-%D0%BF%D1%80%D0%B0%D0%B2%D0%BE%D0%B2%D1%8B%D1%85-%D0%B8%D1%81%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9-232160823883163/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/%D0%A6%D0%B5%D0%BD%D1%82%D1%80-%D0%BF%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%BE-%D0%BF%D1%80%D0%B0%D0%B2%D0%BE%D0%B2%D1%8B%D1%85-%D0%B8%D1%81%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9-232160823883163/">ЦППИ - Центр политико-правовых исследований</a></blockquote></div>

            <br />
            <br />
            <a class="twitter-follow-button"
               href="https://twitter.com/CPLS_Center" data-size="large" data-show-count="false">
                Follow @CPLS_Center</a>
        </div>


        <?php
        if($top_articles){
            ?>
            <div class="col-md-4 oh">

                <h3 class='roboto mb15 navy font19 bbthinblue mb20 pb5'><?=Yii::t('app','Top articles')?></h3>
                <?php
                foreach($top_articles as $art){
                    $title=$art->title." <span class='font11 ml5' title='Просмотры'><i class='fa fa-eye mr4'></i>".$art->views."</span>";
                    echo Html::a("<span class='mr4 block pull-left'>—</span><span class='oh block'>".$title."</span>",['/article/view','id'=>$art->id],['class'=>'mb5 iblock color3 roboto no_underline w100']);
                }
                ?>
            </div>
            <?php
        }
        ?>

        <div class="clear"></div>
        <br />


    </div>
</div>
