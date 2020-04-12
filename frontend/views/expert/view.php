<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Expert */

$this->title = $model->title.' | '.Yii::t('app','CPLR');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Experts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


if($model->image)
    $img=Html::img("@web/images/expert/".$model->id."/s_".$model->image,['class'=>'round author_image_medium']);
else {
    $words = explode(" ", $model->title);
    $acronym = "";

    foreach ($words as $w) {
        $acronym .= mb_substr($w, 0, 1);
    }
    $img="<div class='round initials_thumb iblock'>".$acronym."</div>";
}

if($model->email){$email=Html::a("<span class='glyphicon glyphicon-envelope mr5'></span>Email","mailto:".$model->email,['class'=>'darklink']);}
else $email='';

$articles=Yii::$app->db->createCommand("SELECT id, title FROM article WHERE expert_id='{$model->id}' OR expert2_id='{$model->id}' OR expert2_id='{$model->id}'")->queryAll();
?>
<div class="expert-view mb20">
    <div class="bbgray pb15 mb20 pl20">
        <?=Html::a(Yii::t('app','< View all experts'),['/expert/list'],['class'=>'text-uppercase btn btn-default font12 bold color69'])?>
    </div>
    <div class="text-center bbblue mb40 pb20">
        <?=$img?>
        <h1 class="h1_2"><?= Html::encode($model->title) ?></h1>
        <div class="font18 mb10"><?=$model->description?></div>
        <?=$email?>
    </div>

    <section class="oh">
        <aside class="col-md-3 pr20 pl20">
            <?php
            $dir="files/expert/".$model->id;
            if(is_dir($dir)){
                ?>
                <div class="aside-module">
                    <header class="module-header">
                        <h4><?=Yii::t('app','Download')?></h4>
                    </header>
                    <?php
                    $files=scandir($dir);
                    foreach($files as $file){
                        if($file!='.' && $file!='..'){
                            echo "<div class='mb10'>".Html::a("<span class='fa fa-file-text mr5'></span>".$file,'/'.$dir."/".$file, ['class'=>'darklink'])."</div>";
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </aside>
        <div class="col-md-5 paragraph pt15">
            <?=$model->text;?>
        </div>
        <aside class="col-md-4 pl20 pr20">
           <div class="box_gray">
               <?php
                   if($articles){
                       echo "<div class='text-uppercase bold'>".Yii::t('app','Topics').":</div>";
                       foreach($articles as $article){
                           echo Html::a($article['title'],['/article/view','id'=>$article['id']],['class'=>'font13 underline darklink'])."<br />";
                       }
                   }

                   if($model->expertise_areas){
                       echo Html::tag('div',Yii::t('app','Additional Expertise Areas').":",['class'=>'text-uppercase bold mt15 mb2']);
                       echo Html::tag('div',nl2br($model->expertise_areas),['class'=>'font13 color3 mb10']);
                   }
                   if($model->past_positions && $model->education){
                       echo Html::tag('div',Yii::t('app','Experience').":",['class'=>'text-uppercase bold mt15 mb2']);
                   }
                   if($model->past_positions){
                       echo Html::tag('div',Yii::t('app','Past Positions').":",['class'=>'text-uppercase bold mb2']);
                       echo Html::tag('div',nl2br($model->past_positions),['class'=>'font13 color3 mb10']);
                   }
                   if($model->education){
                       echo Html::tag('div',Yii::t('app','Education').":",['class'=>'text-uppercase bold mb2']);
                       echo Html::tag('div',nl2br($model->education),['class'=>'font13 color3']);
                   }
               ?>
           </div>
        </aside>
    </section>
</div>
