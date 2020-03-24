<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = 'Order # ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if($model->status === 0){
                echo Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']);
            }
            else{
                echo Html::a('Dismiss', ['dismiss', 'id' => $model->id], ['class' => 'btn btn-warning']);
            }
        ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'id_user',
                'format' => 'raw',
                'value' => function ($model) {
                    $array = $model->getUserData();
                    foreach ($array as $item) {
                        return Html::a($item['username'], ['/users/manage/view', 'id' => $item['id']]);
                    }
                }
            ],
            [
                'attribute' => 'id_good',
                'format' => 'raw',
                'value' => function ($model) {
                    $array = $model->getGoodData();
                    foreach ($array as $item) {
                        return Html::a($item['name'], ['/goods/manage/view', 'id' => $item['id']]);
                    }
                }
            ],
            'amount',
            'date:datetime',
            'status',
            'description',
        ],
    ]) ?>

</div>
