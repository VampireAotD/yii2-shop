<?php

namespace backend\models;

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
    const STATUS_ACTIVE  = 0;
    const STATUS_INACTIVE  = 1;

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
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
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


    public function beforeDelete()
    {
        Yii::$app->storage->deletePreviousImage($this->image,'@slides');
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[Good]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::className(), ['id' => 'id_good'])->asArray()->one();
    }

    public function getImage(){
        return Yii::$app->storage->getFile($this->image, '/slides/');
    }

    public static function getStatusList(){
        return [
          self::STATUS_ACTIVE => 'Active',
          self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function countSlides(){
        return static::find()->count();
    }
}
