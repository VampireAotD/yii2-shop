<?php

namespace frontend\components;

use frontend\models\Auth;
use frontend\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

class AuthHandler
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->controller->goHome();
        }

        $attributes = $this->client->getUserAttributes();

        $auth = $this->getAuth($attributes);

        if ($auth) {
            return Yii::$app->user->login($auth);
        }

        if ($user = $this->createAccount($attributes)) {
            return Yii::$app->user->login($user);
        }

        throw new BadRequestHttpException();
    }

    private function getAuth($attributes)
    {
        $email = ArrayHelper::getValue($attributes, 'email');
        return User::findOne(['email' => $email]);
    }

    private function createAccount($attributes)
    {
        $id = ArrayHelper::getValue($attributes, 'id');
        $email = ArrayHelper::getValue($attributes, 'email');
        $name = ArrayHelper::getValue($attributes, 'name');

        if ($email !== null && User::find()->where(['email' => $email])->exists()) {
            return false;
        }

        $user = $this->createUser($email, $name);

        $transaction = User::getDb()->beginTransaction();
        if ($user->save()) {
            $auth = $this->createAuth($id, $user->id);
            if($auth->save()){
                $transaction->commit();
                return $user;
            }
        }
        $transaction->rollBack();
        throw new BadRequestHttpException();
    }

    protected function createUser($email, $name)
    {
        return new User([
            'username' => $name,
            'auth_key' => Yii::$app->security->generateRandomKey(),
            'password_hash' => Yii::$app->security->generateRandomString(),
            'email' => $email,
            'status' => 10,
            'created_at' => $time = time(),
            'updated_at' => $time,
        ]);
    }

    protected function createAuth($source_id, $user_id)
    {
        return new Auth([
            'user_id' => $user_id,
            'source' => $this->client->getId(),
            'source_id' => $source_id
        ]);
    }
}