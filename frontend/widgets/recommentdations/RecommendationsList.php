<?php
namespace frontend\widgets\recommentdations;

use frontend\models\Goods;
use Yii;
use yii\base\Widget;

class RecommendationsList extends Widget
{
    public $criteria = null;

    public function run()
    {
        $model = new Goods;

        if(!$this->criteria){
            $this->criteria = 'date DESC';
        }

        $goods = $model->getRecommendationsList($this->criteria);
        $currency = Yii::$app->cookiesAndSession->getCookieValue('currency');

        return $this->render('block',compact('goods', 'currency'));
    }
}