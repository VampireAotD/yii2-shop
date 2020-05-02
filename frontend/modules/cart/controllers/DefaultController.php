<?php

namespace frontend\modules\cart\controllers;

use frontend\modules\cart\models\CartHandler;
use frontend\modules\cart\models\forms\Checkout;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `cart` module
 */
class DefaultController extends Controller
{
    private $handler;
    private $helper;

    public function init()
    {
        parent::init();
        $this->handler = new CartHandler;
        $this->helper = Yii::$app->cookiesAndSession;
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $items = $this->helper->getSession('basket');
        $model = $this->handler;
        $total = $model->getTotal();
        $currency = Yii::$app->cookiesAndSession->getCookieValue('currency');
        return $this->render('index', compact('items', 'model', 'total', 'currency'));
    }

    /**
     * @param $id
     * @return array|Response
     */
    public function actionAdd($id)
    {
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'counter' => $this->handler->addToCart($id),
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
        if (!$this->handler->deleteItem($id)) {
            Yii::$app->session->setFlash('danger', Yii::t('forms', 'Error while deleting item'));
            return $this->redirect(['/cart/default/index']);
        }
        return $this->redirect(['/cart/default/index']);
    }

    /**
     * @return array|Response
     */
    public function actionChangeAmount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            return ['total' => $this->handler->changeAmount($data)];
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

        if (Yii::$app->request->isPost && $this->handler->load(Yii::$app->request->post())) {
            if ($this->handler->validate()) {
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
        $items = $this->helper->getSession('basket');

        $model = new Checkout($user, $items);
        $total = $this->handler->getTotal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->helper->removeSession('basket');

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
        $this->helper->removeSession('basket');
        return $this->redirect(['/cart/default/index']);
    }
}
