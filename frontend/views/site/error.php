<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="container text-center">
    <div class="logo-404">
        <a href="index.html"><img src="/uploads/static/home/logo.png" alt="" /></a>
    </div>
    <div class="content-404">
        <img src="/uploads/static/404/404.png" class="img-responsive" alt="" />
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    </div>
</div>