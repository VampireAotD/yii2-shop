<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_good
 * @property int $amount
 * @property int|null $date
 * @property int|null $status
 * @property string|null $description
 *
 * @property Goods $good
 * @property User $user
 */
class Orders extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_ARRANGED = 1;
    const STATUS_CANCELLED = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_good', 'amount'], 'required'],
            [['id_user', 'id_good', 'amount', 'date', 'status'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['id_good'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::className(), 'targetAttribute' => ['id_good' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_good' => 'Id Good',
            'amount' => 'Amount',
            'date' => 'Date',
            'status' => 'Status',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Good]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::className(), ['id' => 'id_good']);
    }

    public function getGoodData(){

        return static::find()->select(['goods.id','name'])->innerJoinWith('good')->where(['goods.id' => $this->id_good])->asArray()->all();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getUserData(){
        return static::find()->select(['user.id','username'])->innerJoinWith('user')->where(['user.id' => $this->id_user])->asArray()->all();
    }

    public function approve(){
        $transaction = static::getDb()->beginTransaction();
        $this->status = 1;

        if($this->save(false,['status'])){
            $good = Goods::findOne(['id' => $this->id_good]);
            $good->amount -= $this->amount;
            if($good->save(false,['amount'])){
                $transaction->commit();
                return true;
            }
        }
        $transaction->rollBack();
        return false;
    }

    public function dismiss(){
        $transaction = static::getDb()->beginTransaction();
        $this->status = 2;

        if($this->save(false,['status'])){
            $good = Goods::findOne(['id' => $this->id_good]);
            $good->amount += $this->amount;
            if($good->save(false,['amount'])){
                $transaction->commit();
                return true;
            }
        }
        $transaction->rollBack();
        return false;
    }

    public static function getStatusList(){
        return [
          self::STATUS_PENDING => 'Необработанные',
          self::STATUS_ARRANGED => 'Оформленные',
          self::STATUS_CANCELLED => 'Отмененные',
        ];
    }
}
