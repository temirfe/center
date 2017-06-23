
    <div class="statusbar pr30 pl15">
        <div class="iblock">
            <?php
            echo Html::a("<span class='fa fa-bars fa-fixed-width mr5'></span>".Yii::t('app','Sections'), '#',
                ['class'=>'search small_nav pr15 js_sections_toggle']);
            ?>
        </div>
        <div class="pull-right">
            <?php
            echo Html::a(Yii::t('app','Search')."<span class='fa fa-search search_icon'></span>", ['/site/search'],
                ['class'=>'search small_nav pr15','data-toggle'=>"modal", 'data-target'=>"#search-modal"]);
            if (Yii::$app->user->isGuest) {
                echo Html::a(Yii::t('app','Login')."<span class='fa fa-sign-in ml5'></span>",['/site/login'],['class'=>'small_nav mt1']);
            } else {
                echo Html::a(Yii::t('app','Logout').' (' . Yii::$app->user->identity->username.")<span class='fa fa-sign-out ml5'></span>",['/site/logout'],['class'=>'small_nav mt1', 'data-method'=>'post']);
            }
            ?>
        </div>
        <?=$this->render('/site/_sections');?>
    </div>