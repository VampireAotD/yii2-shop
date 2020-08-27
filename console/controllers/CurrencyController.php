<?php

namespace console\controllers;

use frontend\models\Currencies;
use yii\console\Controller;

class CurrencyController extends Controller
{
    public function actionUpdateCurrencies()
    {
        $apiFetch = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");

        $currencies = Currencies::find()->all();
        $apiCurrencies = json_decode($apiFetch, true);

        $combined = [];

        $combined[] = [
            'code' => 'UAH',
            'value' => 1
        ];

        foreach ($currencies as $currency) {
            foreach ($apiCurrencies as $apiCurrency) {
                if ($currency['code'] === $apiCurrency['ccy']) {
                    $combined[] = [
                        'code' => $currency['code'],
                        'value' => $apiCurrency['sale']
                    ];
                }
            }
        }

        foreach ($combined as $update) {
            $query = "UPDATE {{%currencies}} SET value = {$update['value']} WHERE code = '{$update['code']}'";
            \Yii::$app->db->createCommand($query)->execute();
        }

        echo 'Values were updated!';
    }
}