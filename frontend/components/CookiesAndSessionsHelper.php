<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class CookiesAndSessionsHelper extends Component
{
    public function setSession($name, $value = [])
    {
        return Yii::$app->session->set($name, $value);
    }

    public function getSession($name)
    {
        return Yii::$app->session->get($name);
    }

    public function removeSession($name)
    {
        return Yii::$app->session->remove($name);
    }

    public function inSession($name, $id)
    {
        $session = $this->getSession($name);
        if ($session) {
            foreach ($session as $item) {
                if ($item['id'] === $id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function countSessionElements($name)
    {
        return count($this->getSession($name));
    }

    public function createNewCookie($name, $value, $time = null, $path = '/')
    {
        if (!$time) {
            $time = $this->getDefaultTime();
        }

        return Yii::$app->response->cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
            'expire' => $time,
            'path' => $path
        ]));
    }

    public function getCookieValue($name)
    {
        return Yii::$app->request->cookies->getValue($name);
    }

    public function countElementOfCookieValue($name)
    {
        return count($this->getCookieValue($name));
    }

    public function removeCookie($name)
    {
        return Yii::$app->response->cookies->remove($name);
    }

    public function inCookiesValue($name, $id)
    {
        if ($this->getCookieValue($name)) {
            return ArrayHelper::isIn($id, $this->getCookieValue($name));
        }
    }

    protected function getDefaultTime()
    {
        return Yii::$app->params['defaultCookieTime'];
    }
}