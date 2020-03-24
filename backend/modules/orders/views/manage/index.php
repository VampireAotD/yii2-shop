<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\orders\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    Pjax::begin(['timeout' => 5000]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
            [
                'attribute' => 'amount',
                'format' => 'raw',
                'filter' => [1, 2, 3],
            ],
            'date:datetime',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => \backend\models\Orders::getStatusList(),
                'value' => function($model){
                    switch ($model->status){
                        case 0 :
                            return 'Необработанный';
                        case 1:
                            return 'Оформленный';
                        default:
                            return 'Отмененный';
                    }
                }
            ],
            'description',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {action} {delete}',
                'buttons' => [
                    'action' => function ($url, $model) {
                        switch ($model->status){
                            case 0 :
                                return Html::a('<span class="glyphicon glyphicon-ok"></span>',
                                    Url::to(['approve', 'id' => $model->id]),
                                    ['title' => 'Оформить']);
                            case 1:
                                return Html::a('<span class="glyphicon glyphicon-remove"></span>',
                                    Url::to(['dismiss', 'id' => $model->id]),
                                    ['title' => 'Отменить']);
                            default:
                                return Html::a('<span class="glyphicon glyphicon-ok"></span>',
                                    Url::to(['approve', 'id' => $model->id]),
                                    ['title' => 'Оформить']);
                        }
                    }
                ]
            ],
        ],
    ]);
    Pjax::end();
    ?>


</div>
