<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\slider\models\SlideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slides';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slide-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($slides->countSlides() < 8) : ?>
        <p>
            <?= Html::a('Create Slide', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
