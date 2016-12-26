<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use frontend\assets\MapAsset;

MapAsset::register($this);

$this->title = Yii::t('app','Contact').' | '.Yii::t('app','CPLR');
$this->params['breadcrumbs'][] = $this->title;

$dao=Yii::$app->db;
$result = $dao->createCommand("SELECT * FROM page WHERE url='contact'")->queryOne();
if($result) $text=$result['text']; else $text='';
?>
<div class="site-contact container">
    <h1><?= Yii::t('app','Contact') ?></h1>
    <div class="row">
        <div class="col-md-5">
            <p>
                <?=Yii::t('app','If you have business inquiries or other questions, please fill out the following form to contact us. Thank you');?>.
            </p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <?=$text?>

            <div id="map_view" class="map_view mt20"></div>

        </div>
    </div>


</div>
