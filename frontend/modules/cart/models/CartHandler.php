<?php

namespace frontend\modules\cart\models;

use frontend\components\CookiesAndSessionsHelper;
use frontend\models\Goods;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CartHandler extends Model
{
    /**
     * @var int
     */
    public $quantity;
    /**
     * @var int
     */
    private $total = 0;
    /**
     * @var string
     */
    private $sessionName = 'basket';
    /**
     * @var CookiesAndSessionsHelper
     */
    private $helper;

    public function init()
    {
        parent::init();
        $this->helper = Yii::$app->cookiesAndSession;
    }

    /**
     * Cart validation
     * @return array
     */
    public function rules()
    {
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 1, 'max' => 3],
        ];
    }

    /**
     * Adds item to cart
     * @param $id
     * @return mixed
     */
    public function addToCart($id)
    {
        if (!$this->helper->getSession($this->sessionName)) {
            $this->helper->setSession($this->sessionName, []);
        }

        $exist = false;

        if ($this->helper->inSession($this->sessionName, $id)) {
            $exist = true;
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

            $prev = $this->helper->getSession($this->sessionName);
            $prev [] = $item;
            $this->helper->setSession($this->sessionName, $prev);
        }

        return $this->helper->countSessionElements($this->sessionName);
    }

    /**
     * Deletes item from cart
     * @param $id
     * @return mixed
     */
    public function deleteItem($id)
    {
        return $this->helper->deleteItemFromSession($this->sessionName, $id);
    }

    /**
     * Changes amount of item in cart
     * @param $data
     * @return float|int
     */
    public function changeAmount($data)
    {
        $session = $this->helper->getSession($this->sessionName);

        $id = ArrayHelper::getValue($data, 'id');
        $amount = ArrayHelper::getValue($data, 'amount');

        for ($i = 0; $i < count($session); $i++) {
            if ($session[$i]['id'] == $id) {
                $session[$i]['amount'] = $amount;
                $this->helper->setSession($this->sessionName, $session);
            }
        }

        return $this->getTotal();
    }

    /**
     * Return total sum from cart
     * @return float|int
     */
    public function getTotal()
    {
        $session = $this->helper->getSession($this->sessionName);
        if ($session) {
            foreach ($session as $item) {
                $this->total += $item['amount'] * $item['price'];
            }
            return $this->total;
        }
        return 0;
    }

}