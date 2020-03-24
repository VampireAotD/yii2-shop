<?php
namespace frontend\widgets\recommentdations;

use frontend\models\Goods;
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

        return $this->render('block',compact('goods'));
    }
}