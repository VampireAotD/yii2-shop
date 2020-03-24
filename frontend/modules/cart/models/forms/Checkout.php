<?php

namespace frontend\modules\cart\models\forms;

use frontend\models\Orders;
use Yii;
use yii\base\Model;

class Checkout extends Model
{
    public $username;
    public $email;
    public $description;

    private $user;
    private $session;

    public function __construct($user, $session)
    {
        $this->user = $user;
        $this->session = $session;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('forms', 'Username'),
            'email' => Yii::t('forms','Email'),
            'description' => Yii::t('forms','Description'),
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required', 'skipOnEmpty' => true],
            [['username', 'description'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            foreach ($this->session as $key => $item) {
                $model = new Orders;
                $model->id_user = $this->user->id;
                $model->id_good = $item['id'];
                $model->amount = $item['amount'];
                $model->date = time();
                $model->status = 0;
                if ($key === 0) {
                    $model->description = $this->description;
                }
                $model->save();
            }
            return true;
        }
        return false;
    }
}