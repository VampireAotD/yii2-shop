<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int|null $amount
 * @property string $date
 * @property string|null $image
 * @property int $views
 *
 * @property CategoriesRelation[] $categoriesRelations
 * @property Orders[] $orders
 * @property RecentViews[] $recentViews
 * @property Slide[] $slides
 * @property Subscription[] $subscriptions
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_title', 'name', 'price', 'date'], 'required'],
            [['meta_description', 'description'], 'string'],
            [['price'], 'number'],
            [['amount', 'views'], 'integer'],
            [['date'], 'safe'],
            [['meta_title', 'meta_keywords', 'name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'amount' => 'Amount',
            'date' => 'Date',
            'image' => 'Image',
            'views' => 'Views',
        ];
    }

    /**
     * Gets query for [[CategoriesRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesRelations()
    {
        return $this->hasMany(CategoriesRelation::className(), ['id_good' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['id_good' => 'id']);
    }

    /**
     * Gets query for [[RecentViews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecentViews()
    {
        return $this->hasMany(RecentViews::className(), ['id_good' => 'id']);
    }

    /**
     * Gets query for [[Slides]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSlides()
    {
        return $this->hasMany(Slide::className(), ['id_good' => 'id']);
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['id_good' => 'id']);
    }
}
