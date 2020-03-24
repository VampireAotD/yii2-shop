<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            'id',
//            'meta_title',
//            'meta_description:ntext',
//            'meta_keywords',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($good) {
                    return Html::img($good->getImage());
                }
            ],
            'name',
            //'description:ntext',
            'price',
            'amount',
            //'date',
            //'views',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}  {set-image}  {delete}',
                'buttons' => [
                        'set-image' => function($url, $good){
                            return Html::a('<span class="glyphicon glyphicon-picture"></span>',['upload-image', 'id' => $good->id], ['title' => 'Изменить изображение']);
                        }
                ]
            ],
        ],
    ]); ?>


</div>
