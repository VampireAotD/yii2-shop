<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categories_relation".
 *
 * @property int $id
 * @property int|null $id_cat
 * @property int|null $id_good
 *
 * @property Categories $cat
 * @property Goods $good
 */
class CategoriesRelation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_good'], 'integer'],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['id_cat' => 'id']],
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
            'id_cat' => 'Id Cat',
            'id_good' => 'Id Good',
        ];
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'id_cat']);
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
