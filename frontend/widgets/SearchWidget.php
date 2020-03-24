<?php

namespace frontend\widgets;

use frontend\models\Goods;
use yii\base\Widget;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

class SearchWidget extends Widget
{
    public function run()
    {
        return AutoComplete::widget([
            'name' => 'search',
            'options' => ['placeholder' => 'Search',],
            'clientOptions' => [
                'source' => Goods::find()->select(['name AS value','image','id'])->asArray()->all(),
                'minLength' => 3,
                'create' => new JsExpression('function(event, ui) {
                      $(event.target).autocomplete("instance")._renderItem = function(ul, item) {
                        if(item.image === null || item.image === ""){
                            item.image = "no-image.jpg";
                        }
                        return $("<li>").append(`<a href="/good/${item.id}"><img src=http://yiishop.com.ua/uploads/${item.image}>${item.value}</a>`).appendTo(ul);
                       };
                    }'
                )
            ]
        ]);
    }
}