<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;

AppAsset::register($this);
FontAwesomeAsset::register($this);
$controller=Yii::$app->controller->id;
$action=Yii::$app->controller->action->id;

if(!isset($user)) $user=Yii::$app->user;
if(!isset($isGuest)) $isGuest=$user->isGuest;
if(!isset($identity)) $identity=$user->identity;
if(!isset($user_id) && $identity) $user_id=$identity->id; else $user_id='';
if(!isset($user_name) && $identity) $user_name=$identity->username; else $user_name='';
if(!isset($user_role) && $identity) $user_role=$identity->role; else $user_role='';
if(!isset($dao)) $dao=Yii::$app->db;

if($controller=='site' && $action=="about") $about_active=true; else $about_active=false;
if($controller=='expert') $expert_active=true; else $expert_active=false;
if($controller=='article') $article_active=true; else $article_active=false;
if($controller=='event') $event_active=true; else $event_active=false;
if($controller=='site' && $action=="partners") $partner_active=true; else $partner_active=false;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body data-spy="scroll" data-target="#myScrollspy" data-offset="140" id="top">
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '382095758792121',
            xfbml      : true,
            version    : 'v2.8'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };

        return t;
    }(document, "script", "twitter-wjs"));</script>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if(!$isGuest && $user_role=='admin'){include_once('_adminpanel.php');}
    //elseif(!$isGuest && $user_role=='Moderator'){include_once('_moderpanel.php');}
    //elseif(!$isGuest && $user_role=='ContentManager'){include_once('_cmanagerpanel.php');}
    NavBar::begin([
        'brandLabel' => "<div class='logo_wrap  logo_wrap_index js_logo_wrap'></div>",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'mynavbar navbar',
        ],
        'innerContainerOptions'=>['class'=>'nav_wrap large-container']
    ]);
    $menuItems = [
        ['label' => Yii::t('app','Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('app','About us'), 'url' => ['/about'], 'active'=>$about_active],
        ['label' => Yii::t('app','Articles'), 'url' => ['/article/list'], 'active'=>$article_active],
        ['label' => Yii::t('app','Events'), 'url' => ['/event/list'],'active'=>$event_active],
        ['label' => Yii::t('app','Experts'), 'url' => ['/expert/list'], 'active'=>$expert_active],
        ['label' => Yii::t('app','Our partners'), 'url' => ['/partners'],'active'=>$partner_active],
        ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);

    echo "<div class='pull-right mt10'>".Html::a(Yii::t('app','Search')."<span class='fa fa-search search_icon'></span>", ['/site/search'],
            ['class'=>'search small_nav pr15','data-toggle'=>"modal", 'data-target'=>"#search-modal"])."</div>";

    NavBar::end();

    ?>
    <?php /*echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])*/ ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="footer">
    <div class="large-container pb10">
        <div class="pull-left mr10 mt5">
            <?=Yii::t('app','Follow us on ')?>
        </div>
        <div class="text-left">
            <a class="share-facebook share-icon" rel="nofollow" href="https://www.facebook.com/%D0%A6%D0%B5%D0%BD%D1%82%D1%80-%D0%BF%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%BE-%D0%BF%D1%80%D0%B0%D0%B2%D0%BE%D0%B2%D1%8B%D1%85-%D0%B8%D1%81%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9-232160823883163/" title="<?=Yii::t('app','Facebook');?>">
                <span></span>
            </a>
            <a class="share-twitter share-icon" rel="nofollow" href="https://twitter.com/CPLS_Center" title="<?=Yii::t('app','Twitter');?>">
                <span></span>
            </a>
            <a class="share-youtube share-icon" rel="nofollow" href="https://www.youtube.com/channel/UCriqO1LQc7Xry8aw5CzUlyw" title="<?=Yii::t('app','YouTube');?>">
                <span></span>
            </a>
        </div>
        <p class="text-center mb5 font12"><?=Yii::t('app','All rights reserved.')?> &copy; <?= date('Y') ?></p>
        <div class="text-center mb0">
            <!-- WWW.NET.KG , code for http://center.kg -->
            <script language="javascript" type="text/javascript">
                java="1.0";
                java1=""+"refer="+escape(document.referrer)+"&amp;page="+escape(window.location.href);
                document.cookie="astratop=1; path=/";
                java1+="&amp;c="+(document.cookie?"yes":"now");
            </script>
            <script language="javascript1.1" type="text/javascript">
                java="1.1";
                java1+="&amp;java="+(navigator.javaEnabled()?"yes":"now");
            </script>
            <script language="javascript1.2" type="text/javascript">
                java="1.2";
                java1+="&amp;razresh="+screen.width+'x'+screen.height+"&amp;cvet="+
                    (((navigator.appName.substring(0,3)=="Mic"))?
                        screen.colorDepth:screen.pixelDepth);
            </script>
            <script language="javascript1.3" type="text/javascript">java="1.3"</script>
            <script language="javascript" type="text/javascript">
                java1+="&amp;jscript="+java+"&amp;rand="+Math.random();
                document.write("<a href='https://www.net.kg/stat.php?id=5556&amp;fromsite=5556' target='_blank'>"+
                    "<img src='https://www.net.kg/img.php?id=5556&amp;"+java1+
                    "' border='0' alt='WWW.NET.KG' width='21' height='16' /></a>");
            </script>
            <noscript>
                <a href='https://www.net.kg/stat.php?id=5556&amp;fromsite=5556' target='_blank'><img
                        src="https://www.net.kg/img.php?id=5556" border='0' alt='WWW.NET.KG' width='21'
                        height='16' /></a>
            </noscript>
            <!-- /WWW.NET.KG -->

        </div>
        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a(Yii::t('app','Login')."<span class='fa fa-sign-in ml5'></span>",['/site/login'],['class'=>'small_nav mt1']);
        } else {
            echo Html::a(Yii::t('app','Logout').' (' . Yii::$app->user->identity->username.")<span class='fa fa-sign-out ml5'></span>",['/site/logout'],['class'=>'small_nav mt1', 'data-method'=>'post']);
        }
        ?>

    </div>
</footer>
<a href="#" class="scrollToTop"><span class="fa fa-arrow-up"></span></a>
<?php $this->endBody() ?>
<?php
$modal = Modal::begin([
    'id' => 'search-modal',
    'header' => Html::tag('h4', Yii::t('app', 'Search'), ['class' => 'modal-title']),
]);
echo $this->render('/site/_search_form',['ctg'=>'','queryWord'=>'']);
$modal::end();
?>
</body>
</html>
<?php $this->endPage() ?>
