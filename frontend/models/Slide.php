<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "slide".
 *
 * @property int $id
 * @property string|null $image
 * @property int|null $id_good
 * @property int|null $status
 *
 * @property Goods $good
 */
class Slide extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slide';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_good', 'status'], 'integer'],
            [['image'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'id_good' => 'Id Good',
            'status' => 'Status',
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

    public function getSlideList(){
        return static::find()->where(['status' => 0])->all();
    }

    public function getImage(){
        return Yii::$app->storage->getFile($this->image, '/slides/');
    }
}
