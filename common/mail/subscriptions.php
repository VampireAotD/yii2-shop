<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $good \backend\models\Goods */
/* @var $user \backend\models\User */

$link = Yii::$app->urlManager->createAbsoluteUrl(['good/default/index', 'id' => $good->id]);
?>
<div class="subscription">

    <p>Новая партия игры:</p>

    <p><?= Html::a(Html::encode($good->name), $link) ?></p>
</div>
