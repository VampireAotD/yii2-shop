<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Slide */

$this->title = 'Update Slide: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slides', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Slide '.$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slide-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'goods' => $goods,
        'statuses' => $statuses,
    ]) ?>

</div>
