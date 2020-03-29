<?php
namespace frontend\modules\wishlist\controllers;

use frontend\models\Goods;
use Yii;
use yii\web\Controller;
use frontend\modules\wishlist\models\WishlistHandler;
use yii\web\Response;

/**
 * Default controller for the `wishlist` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $ids = Yii::$app->cookiesAndSession->getCookieValue('wishlist');
        $wishlist = Goods::find()->where(['id' => $ids])->all();
        return $this->render('index', compact('wishlist'));
    }

    public function actionAdd($id)
    {
        if(Yii::$app->request->isAjax){
            $handler = new WishlistHandler(Yii::$app->cookiesAndSession);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'counter' => $handler->addToWishlist($id) + 1,
            ];
        }
        return $this->goHome();
    }

    public function actionDelete($id){
        $handler = new WishlistHandler(Yii::$app->cookiesAndSession);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'counter' => $handler->deleteFromWishlist($id) - 1,
        ];
    }

    public function actionClear(){
        Yii::$app->cookiesAndSession->removeSession('wishlist');
        Yii::$app->cookiesAndSession->removeCookie('wishlist');
        return $this->redirect(['/wishlist/default/index']);
    }
}
