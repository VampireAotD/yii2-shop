<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('forms', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
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
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('forms', 'Please fill out the following fields to signup') ?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'confirm')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('forms', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5">
            <h2><?= Yii::t('forms', 'Or login via Facebook') ?> :</h2>
            <?= AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode' => true,
            ]) ?>
        </div>
    </div>
</div>
