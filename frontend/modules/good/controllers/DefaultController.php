<?php

namespace frontend\modules\good\controllers;

use frontend\models\Goods;
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
        $good->updateViews();
        $good->viewedBy();

        return $this->render('index',compact('good'));
    }

    protected function findGood($id){
        $good = Goods::findOne($id);
        if($good){
            return $good;
        }
        throw new NotFoundHttpException();
    }
}
