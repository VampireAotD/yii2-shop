<?php

namespace frontend\modules\cart\controllers;

use frontend\models\Goods;
use frontend\modules\cart\models\CartHandler;
use frontend\modules\cart\models\forms\Checkout;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `cart` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $items = Yii::$app->cookiesAndSession->getSession('basket');
        $model = new CartHandler;
        $total = $model->getTotal();
        return $this->render('index', compact('items', 'model', 'total'));
    }

    /**
     * @param $id
     * @return array|Response
     */
    public function actionAdd($id)
    {
        if(Yii::$app->request->isAjax){
            $handler = new CartHandler;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'counter' => $handler->addToCart($id),
            ];
        }
        return $this->goHome();
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $model = new CartHandler;
        $model->deleteItem($id);
        return $this->redirect(['/cart/default/index']);
    }

    /**
     * @return array|Response
     */
    public function actionChangeAmount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $handler = new CartHandler;
            $data = Yii::$app->request->post();
            return ['total' => $handler->changeAmount($data)];
        }
        return $this->redirect(['/cart/default/index']);
    }

    /**
     * @return Response
     */
    public function actionCheckout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/signup']);
        }

        $model = new CartHandler;
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                return $this->redirect(['/cart/default/checkout-confirm']);
            }
        }

        return $this->goBack();
    }

    /**
     * @return string|Response
     */
    public function actionCheckoutConfirm()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/signup']);
        }

        $user = Yii::$app->user->identity;
        $items = Yii::$app->cookiesAndSession->getSession('basket');

        $model = new Checkout($user, $items);
        $handler = new CartHandler;

        $total = $handler->getTotal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cookiesAndSession->removeSession('basket');
            Yii::$app->session->setFlash('success', 'Ваш заказ был успешно оформлен!');
            return $this->redirect(['/site/index']);
        }

        return $this->render('checkout', compact('model', 'total'));
    }

    /**
     * @return Response
     */
    public function actionClear()
    {
        Yii::$app->cookiesAndSession->removeSession('basket');
        return $this->redirect(['/cart/default/index']);
    }
}
