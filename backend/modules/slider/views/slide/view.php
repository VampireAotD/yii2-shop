<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Slide */

$this->title = 'Slide '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="slide-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add image', ['add-image', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($slide) {
                    return Html::img($slide->getImage(), ['width' => '750px']);
                }
            ],
            [
                'attribute' => 'id_good',
                'format' => 'raw',
                'label' => 'Good',
                'value' => function ($slide) {
                    return Html::a($slide->getGood()['name'], ['/goods/manage/view', 'id' => $slide->getGood()['id']]);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($slide) {
                    return Html::tag('span', $slide->status === 1 ? 'Inactive' : 'Active');
                }
            ],
        ],
    ]) ?>

</div>
