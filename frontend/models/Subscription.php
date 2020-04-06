<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property string $email
 * @property int $id_good
 *
 * @property Goods $good
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'id_good'], 'required'],
            [['id_good'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['id_good'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::className(), 'targetAttribute' => ['id_good' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'id_good' => 'Id Good',
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

    public function subscribe(){
        if($this->validate()){
            $subscription = Subscription::find()->where(['email' => $this->email, 'id_good' => $this->id_good])->one();
            if($subscription){
                return true;
            }
            return $this->save();
        }
        return false;
    }

}
