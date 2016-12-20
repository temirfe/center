<?php
use yii\helpers\Html;
?>
<style type="text/css">
    .navbar-fixed-top, .navbar-fixed-bottom {
        position: relative;
    }
    .wrap > .container {
        padding-top: 0;
    }
</style>
<?php
$pages_active='';
$users_active='';
$article_active='';
$event_active='';
$expert_active='';
$banner_active='';
$category_active='';
$controller=Yii::$app->controller->id;
if($controller=='page') $pages_active="active";
else if($controller=='user') $users_active="active";
else if($controller=='article') $article_active="active";
else if($controller=='event') $event_active="active";
else if($controller=='expert') $expert_active="active";
else if($controller=='banner') $banner_active="active";
else if($controller=='category') $category_active="active";
?>
<div class="admpanel_top">
      <div class="admpanel-title">
          <div class="admpanel-title-wrapper">Admin panel<span class="openclose js_openclose">Hide - </span></div>
      </div>
      <div class="admpanel-content js_admpanel-content">
      	<div class="top_admpanel_wrapper">
            <div class="operations">
                <div class="<?=$pages_active?>"><span class='panel-icon glyphicon glyphicon-file'></span><?=Html::a(Yii::t('app','Pages'), ['/page/index']); ?></div>
                <div class="<?=$article_active?>"><span class='panel-icon glyphicon glyphicon-font'></span><?=Html::a(Yii::t('app','Articles'), ['/article/index']); ?></div>
                <div class="<?=$event_active?>"><span class='panel-icon glyphicon glyphicon-calendar'></span><?=Html::a(Yii::t('app','Events'), ['/event/index']); ?></div>
                <div class="<?=$expert_active?>"><span class='panel-icon glyphicon glyphicon-briefcase'></span><?=Html::a(Yii::t('app','Experts'), ['/expert/index']); ?></div>
                <div class="<?=$category_active?>"><span class='panel-icon glyphicon glyphicon-tasks'></span><?=Html::a(Yii::t('app','Categories'), ['/category/index']); ?></div>
                <div class="<?=$banner_active?>"><span class='panel-icon glyphicon glyphicon-bookmark'></span><?=Html::a(Yii::t('app','Home banner'), ['/banner/index']); ?></div>
                <div class="<?=$users_active?>"><span class='panel-icon glyphicon glyphicon-user'></span><?=Html::a(Yii::t('app','Users'), ['/user/index']); ?></div>
             </div>
             <div class="clear"></div>
                <?php
                $id=Yii::$app->request->get('id');
                $action=Yii::$app->controller->action->id;
                if($action=='view' && $id)
                {
                    ?>
                    <div class="operations" style="padding: 4px 13px; background-color: #000;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> '.Yii::t('app','List'), ['index'], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> '.Yii::t('app','Create'), ['create'], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil panel-icon2"></span> '.Yii::t('app','Update'), ['update', 'id' => $id], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove panel-icon2"></span> '.Yii::t('app','Delete'), ['delete', 'id' => $id], [
                            'data' => [
                                'confirm' => Yii::t('app','Are you sure you want to delete?'),
                                'method' => 'post',
                            ],'style'=>'margin-right:30px;'
                        ]) ?>
                        <?php
                        if($controller=='package'){
                            echo Html::a('<span class="glyphicon glyphicon-tag panel-icon2"></span> '.Yii::t('app','Add item'),
                                ['/item/create', 'parent_id' => $id], ['class' => 'mr30']);
                        }
                        ?>
                    </div>
                <?php
                }
                elseif(in_array($action,['index','admin','update','list']) && Yii::$app->controller->id!='site')
                {
                    ?>
                    <div class="operations" style="padding: 4px 13px; background-color: #000;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> '.Yii::t('app','List'), ['index'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> '.Yii::t('app','Create'), ['create'], ['class' => '','style'=>'margin-right:30px;']) ?>
                    </div>
                <?php
                }
                ?>
         </div>
    </div>
</div>  