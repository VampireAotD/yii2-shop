<?php

namespace frontend\components;

use yii\base\Component;

class Currencies extends Component
{
    public function getPrice($getCurrency, $price)
    {
        $getCurrencies = \Yii::$app->cache->getOrSet('getCurrencies', function () {
            return file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");
        });

        $currencies = json_decode($getCurrencies, true);

        foreach ($currencies as $currency) {
            if ($currency['ccy'] === $getCurrency) {
                switch ($getCurrency) {
                    case 'USD' :
                    case 'EUR':
                    case 'RUR' :
                        return ceil($price / $currency['sale']);
                    default :
                        return ceil($price);
                }
            }
        }

        return ceil($price);
    }
}