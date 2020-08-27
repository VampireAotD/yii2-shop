<?php

namespace frontend\widgets;

use frontend\models\Goods;
use yii\base\Widget;
use yii\jui\Slider;
use yii\web\JsExpression;

class PriceRangeWidget extends Widget
{
    public function run()
    {
        return Slider::widget([
            'options' => ['name' => 'price-range',],
            'clientOptions' => [
                'min' => 0,
                'max' => Goods::getMaxPrice(),
                'range' => true,
                'value' => [0, Goods::getMaxPrice()],
            ],
            'clientEvents' => [
                'slide' => new JsExpression('function(event){
                    $(".price-change").val(event.value);
               }'),
            ]
        ]);
    }
}