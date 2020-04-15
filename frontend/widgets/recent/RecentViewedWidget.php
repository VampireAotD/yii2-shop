<?php

namespace frontend\widgets\recent;

use frontend\models\RecentViews;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class RecentViewedWidget extends Widget
{
    public function run()
    {
        $init = RecentViews::find()
            ->where(['user_ip' => Yii::$app->request->userIP])
            ->innerJoinWith('good')
            ->orderBy('expire DESC')
            ->limit(6)
            ->all();
        $goods = ArrayHelper::getColumn($init,'good');
        return $this->render('block', compact('goods'));
    }
}