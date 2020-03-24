<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add image', ['upload-image', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
            'meta_title',
            'meta_description:ntext',
            'meta_keywords',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($good) {
                    return Html::img($good->getImage());
                }
            ],
            'name',
            'description:ntext',
            'price',
            'amount',
            'date:date',
            'views',
            [
                'attribute' => 'categories',
                'format' => 'raw',
                'value' => function ($good) {
                    $categories = [];
                    foreach ($good->getCurrentCategories() as $keyCategory => $currentCategory) {
                        $categories [] = Html::a($currentCategory,['/categories/manage/view','id' => $keyCategory]);
                    }
                    return implode(' ',$categories);
                }
            ],
        ],
    ]) ?>

</div>
