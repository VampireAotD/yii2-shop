<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\LoginForm */

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('forms','Login');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Вход,Yii shop'
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

<section id="form"><!--form-->
    <div class="container">
        <div class="row" style="display:flex; justify-content: center">
            <div class="col-sm-6">
                <div class="login-form"><!--login form-->
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <span>
                        <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'checkbox']) ?>
                    </span>
                    <?= $form->field($model, 'reCaptcha')->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha2::className(),
                        [
                            'siteKey' => '6LesYOMUAAAAAMnlVIYpvWB85GspTQcPmzxeoIvP', // unnecessary is reCaptcha component was set up
                        ]
                    )->label(false) ?>
                    <div style="color:#999;margin:1em 0">
                        <?=Yii::t('forms','If you forgot your password you can')?><?= Html::a(Yii::t('forms','reset it'), ['site/request-password-reset']) ?>.
                        <br>
                        Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div><!--/login form-->
            </div>
            <div class="col-sm-6">
                <h2><?=Yii::t('forms','Or login via Facebook')?></h2>
                <?= AuthChoice::widget([
                    'baseAuthUrl' => ['site/auth'],
                    'popupMode' => true,
                ]) ?>
            </div>
        </div>
    </div>
</section><!--/form-->
