<?php

namespace frontend\modules\wishlist\models;

use frontend\components\CookiesAndSessionsHelper;
use Yii;

class WishlistHandler
{
    private $handler;

    public function __construct(CookiesAndSessionsHelper $handler)
    {
        $this->handler = $handler;
    }

    public function addToWishlist($id)
    {
        $session = $this->handler->getSession('wishlist');
        $exist = false;
        if (!$session) {
            $this->handler->setSession('wishlist');
        }

        if ($session) {
            foreach ($session as $item) {
                if ($item == $id) {
                    $exist = true;
                    break;
                }
            }
        }

        if (!$exist) {
            $session[] = $id;
            $this->handler->setSession('wishlist', $session);
        }

        $this->handler->createNewCookie('wishlist', $session);

        return $this->handler->countElementOfCookieValue('wishlist');
    }

    public function deleteFromWishlist($id)
    {
        $wishlist = $this->handler->getSession('wishlist');
        for ($i = 0; $i < count($wishlist); $i++) {
            if ($wishlist[$i] == $id) {
                unset($wishlist[$i]);
                break;
            }
        }

        $clear_list = [];
        foreach ($wishlist as $item) {
            $clear_list [] = $item;
        }
        $this->handler->removeSession('wishlist');
        $this->handler->setSession('wishlist', $clear_list);
        unset($clear_list);

        $this->handler->removeCookie('wishlist');
        $this->handler->createNewCookie('wishlist', Yii::$app->cookiesAndSession->getSession('wishlist'));

        if (empty($this->handler->getSession('wishlist'))) {
            $this->handler->removeCookie('wishlist');
        }

        return $this->handler->countElementOfCookieValue('wishlist');
    }
}