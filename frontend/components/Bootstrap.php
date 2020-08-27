<?php

namespace frontend\components;

use frontend\models\RecentViews;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     * @return bool
     */
    public function bootstrap($app)
    {
        if (Yii::$app->request->cookies->get('wishlist')) {
            Yii::$app->cookiesAndSession->setSession('wishlist', Yii::$app->cookiesAndSession->getCookieValue('wishlist'));
        }

        $cookie = Yii::$app->cookiesAndSession->getCookieValue('language');
        if ($cookie) {
            $app->language = $cookie;
        }

        $this->clearRecent();

        return true;
    }

    private function clearRecent()
    {
        return RecentViews::deleteAll(['<=', 'expire', time()]);
    }
}