<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use frontend\models\Event;

/* @var $this yii\web\View */
/* @var $model frontend\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$dao = Yii::$app->db;
$items = $dao->createCommand("SELECT * FROM project_items WHERE project_id='{$model->id}'")->queryAll();
$art_ids = [];
$vid_ids = [];
$ev_ids = [];
foreach ($items as $item) {
    switch ($item['item']) {
        case 'article':
            $art_ids[] = $item['item_id'];
            break;
        case 'video':
            $vid_ids[] = $item['item_id'];
            break;
        case 'event':
            $ev_ids[] = $item['item_id'];
            break;
    }
    if ($art_ids) {
        $artIds = implode(',', $art_ids);
        $articles = $dao->createCommand("SELECT * FROM article WHERE id IN({$artIds}) ORDER BY id DESC")->queryAll();
    }
    if ($vid_ids) {
        $vidIds = implode(',', $vid_ids);
        $videos = $dao->createCommand("SELECT * FROM video WHERE id IN({$vidIds}) ORDER BY id DESC")->queryAll();
    }
    if ($ev_ids) {
        $evIds = implode(',', $ev_ids);
        $events = $dao->createCommand("SELECT * FROM `event` WHERE id IN({$evIds}) ORDER BY id DESC")->queryAll();
    }
}
?>
<div class="project-view container">
    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="clear"></div>

    <?php
    if ($model->image) {
        $img = Html::img('/images/project/' . $model->id . '/' . $model->image, ['class' => 'w100']);
        echo Html::tag('div', $img, ['class' => 'w300px mr20 pull-left']);
    }
    echo $model->text;
    echo Html::tag('div', '', ['class' => 'clear']);

    if (isset($articles)) {
        echo Html::tag('h3', Yii::t('app', 'Articles'));
        echo Html::beginTag('div', ['class' => 'row']);
        $a = 0;
        foreach ($articles as $article) {
            if ($article['image']) {
                $img = Html::img("/images/article/" . $article['id'] . "/s_" . $article['image'], ['class' => 'img-responsive']);
            } else $img = "<div class='no_img text-center'>" . Html::img("/images/logo_simple.png", ['class' => 'slider']) . "</div>";
            echo Html::beginTag('div', ['class' => 'col-sm-4']);
            echo Html::a($img, ['/article/view', 'id' => $article['id']], ['class' => 'img-responsive rel js_des_list_img mb15']);
            echo Html::a($article['title'], ['/article/view', 'id' => $article['id']], ['class' => 'black roboto font16']);
            $time = strtotime($article['date_create']);
            echo Html::tag('time', date("d.m.Y", $time), ['class' => 'date']);
            echo Html::endTag('div');
            $a++;
            if ($a == 3) {
                break;
            }
        }
        echo Html::endTag('div');
        if (count($articles) > 3) {
            echo Html::a('Все статьи', ['article/index?project_id=' . $model->id], ['class' => 'pull-right']);
        }
    }

    if (isset($videos)) {
        $v = 0;
        echo Html::tag('h3', Yii::t('app', 'Videos'));
        echo Html::beginTag('div', ['class' => 'row']);
        foreach ($videos as $video) {
            $img = Html::img($video['thumb'], ['class' => 'img-responsive']);
            echo Html::beginTag('div', ['class' => 'col-sm-4']);
            echo Html::a($img, ['/video/view', 'id' => $video['id']], ['class' => 'img-responsive rel js_des_list_img mb15']);
            echo Html::a($video['title'], ['/video/view', 'id' => $video['id']], ['class' => 'black roboto font16']);
            $time = strtotime($video['date_create']);
            echo Html::tag('time', date("d.m.Y", $time), ['class' => 'date']);
            echo Html::endTag('div');
            $v++;
            if ($v == 3) {
                break;
            }
        }
        echo Html::endTag('div');
        if (count($videos) > 3) {
            echo Html::a('Все видео', ['video/index?project_id=' . $model->id], ['class' => 'pull-right']);
        }
    }

    if (isset($events)) {
        $e = 0;
        echo Html::tag('h3', Yii::t('app', 'Events'));
        foreach ($events as $event) {
            $start = strtotime($event['date_start']);
            $week = Yii::$app->formatter->asDatetime($start, 'ccc');
            $month = Yii::$app->formatter->asDatetime($start, 'MMM');
            $day = Yii::$app->formatter->asDatetime($start, 'd');
            $start_time = Yii::$app->formatter->asDatetime($start, 'H:mm');
            $status = Event::getStatusStatic($event['date_start'], $event['date_end']);
            $label = $status['msg'];
    ?>
            <div class='event-date list pull-left mr15 rel'>
                <div class='date-day'><?= $week ?></div>
                <div class='date-number'><?= $day ?></div>
                <div class='date-month'><?= $month ?></div>
                <?= Html::a("", ['/event/view', 'id' => $event['id']], ['class' => 'false_link']); ?>
            </div>
            <div class="event-info oh">
                <span class="event_label"><?= $label ?></span>
                <h4 class="title"><?= Html::a($event['title'], ['/event/view', 'id' => $event['id']], ['class' => 'darklink']); ?></h4>
                <div class="times">
                    <?php
                    if ($status['register']) {
                        echo Yii::t('app', 'Starts at');
                        echo " <time>" . $start_time . "</time>";
                    }
                    ?>
                </div>
            </div>
    <?php
            $e++;
            if ($e == 3) {
                break;
            }
        }
        if (count($events) > 3) {
            echo Html::a('Все мероприятия', ['event/index?project_id=' . $model->id], ['class' => 'pull-right']);
        }
    }

    ?>

</div>