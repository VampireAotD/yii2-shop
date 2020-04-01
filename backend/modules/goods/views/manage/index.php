<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    Pjax::begin(['timeout' => 5000]);
    echo $this->render('_search', ['model' => $searchModel]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($good) {
                    return Html::img($good->getImage(), ['width' => '150px']);
                }
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($good) {
                    return Html::a($good->name, ['view', 'id' => $good->id]);
                }
            ],
            'price',
            'amount',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}  {set-image}  {delete}',
                'buttons' => [
                    'set-image' => function ($url, $good) {
                        return Html::a('<span class="glyphicon glyphicon-picture"></span>', ['upload-image', 'id' => $good->id], ['title' => 'Изменить изображение']);
                    }
                ]
            ],
        ],
    ]);
    Pjax::end();
    ?>


</div>
