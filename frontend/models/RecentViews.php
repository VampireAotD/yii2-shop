<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recent_views".
 *
 * @property int $id
 * @property string|null $user_ip
 * @property int|null $id_good
 * @property int|null $viewed
 * @property int|null $expire
 *
 * @property Goods $good
 */
class RecentViews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recent_views';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_good', 'viewed', 'expire'], 'integer'],
            [['user_ip'], 'string', 'max' => 255],
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
            'user_ip' => 'User Ip',
            'id_good' => 'Id Good',
            'viewed' => 'Viewed',
            'expire' => 'Expire',
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
}
