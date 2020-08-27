<?php

namespace frontend\modules\good\controllers;

use frontend\models\Goods;
use frontend\models\Subscription;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `good` module
 */
class DefaultController extends Controller
{
    /**
     * Renders index view
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $good = $this->findGood($id);
        $subscribeModel = new Subscription();
        $good->updateViews();
        $good->viewedBy();
        $similarGoods = $good->getSimilarGoods();
        $currency = Yii::$app->cookiesAndSession->getCookieValue('currency');

        return $this->render('index', compact('good', 'subscribeModel', 'similarGoods', 'currency'));
    }

    public function actionSubscribe()
    {
        if (Yii::$app->request->isPost) {
            $model = new Subscription();

            if ($model->load(Yii::$app->request->post()) && $model->subscribe()) {
                Yii::$app->session->setFlash('success', 'Success');
                return $this->refresh();
            }
        }

        return $this->goBack();
    }

    protected function findGood($id)
    {
        $good = Goods::findOne($id);
        if ($good) {
            return $good;
        }
        throw new NotFoundHttpException();
    }
}
