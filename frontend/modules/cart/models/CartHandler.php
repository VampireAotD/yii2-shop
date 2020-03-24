<?php

namespace frontend\modules\cart\models;

use frontend\models\Goods;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CartHandler extends Model
{
    public $quantity;
    private $total = 0;

    public function addToCart($id)
    {
        $helper = Yii::$app->cookiesAndSession;

        if (!$helper->getSession('basket')) {
            $helper->setSession('basket', []);
        }

        $exist = false;
        $session = $helper->getSession('basket');

        for ($i = 0; $i < count($session); $i++) {
            if ($session[$i]['id'] == $id) {
                $exist = true;
                $session[$i]['amount']++;
                $helper->setSession('basket', $session);
                break;
            }
        }

        if (!$exist) {
            $good = Goods::findOne($id);
            $item = [
                'id' => $good['id'],
                'name' => $good['name'],
                'image' => $good['image'],
                'price' => $good['price'],
                'amount' => 1
            ];

            $prev = $helper->getSession('basket');
            $prev [] = $item;
            $helper->setSession('basket', $prev);
        }

        return Yii::$app->cookiesAndSession->countSessionElements('basket');
    }

    public function deleteItem($id)
    {
        $helper = Yii::$app->cookiesAndSession;
        $session = $helper->getSession('basket');

        for ($i = 0; $i < count($session); $i++) {
            if ($session[$i]['id'] == $id) {
                unset($session[$i]);
                break;
            }
        }

        $items = [];
        foreach ($session as $item) {
            $items [] = $item;
        }

        Yii::$app->session->remove('basket');
        Yii::$app->cookiesAndSession->setSession('basket', $items);
        unset($items);
    }

    public function getTotal()
    {
        $session = Yii::$app->cookiesAndSession->getSession('basket');
        if ($session) {
            foreach ($session as $item) {
                $this->total += $item['amount'] * $item['price'];
            }
        }
        return $this->total;
    }

    public function rules()
    {
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 1, 'max' => 3],
        ];
    }

}