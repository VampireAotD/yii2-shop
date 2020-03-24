<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Slide */
/* @var $form yii\widgets\ActiveForm */
/* @var $goods \backend\models\Goods*/
/* @var $statuses \backend\models\Goods*/
?>

<div class="slide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_good')->dropDownList($goods) ?>
    <?= $form->field($model, 'status')->dropDownList($statuses) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
