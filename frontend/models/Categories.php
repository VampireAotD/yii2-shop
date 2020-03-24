<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 *
 * @property CategoriesRelation[] $categoriesRelations
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[CategoriesRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesRelations()
    {
        return $this->hasMany(CategoriesRelation::className(), ['id_cat' => 'id']);
    }

    public function getCategoriesList(){
        return static::find()->all();
    }
}
