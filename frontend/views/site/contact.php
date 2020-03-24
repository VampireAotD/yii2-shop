<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('forms','Contact');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Обратная связь,Yii shop'
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
$this->registerMetaTag([
    'name' => 'title',
    'content' => $this->title
]);
?>
<div id="contact-page" class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=Yii::t('forms','If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.')?>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <div class="col-sm-12">
                <div class="contact-form">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'class' => 'contact-form row']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'cols' => 12]) ?>

                    <?= $form->field($model, 'reCaptcha')->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha2::className()
                    )->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
