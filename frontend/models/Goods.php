<?php

namespace frontend\models;

use common\components\Storage;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property int|null $views
 *
 * @property CategoriesRelation[] $categoriesRelations
 */
class Goods extends ActiveRecord
{
    const TIME = 60 * 60 * 24 * 3;

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
            [['date', 'views'], 'safe'],
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

    public function getCategories()
    {
        $categories = $this->hasMany(Categories::class, ['id' => 'id_cat'])->viaTable('{{categories_relation}}', ['id_good' => 'id'])->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }

    public function getGoodsList()
    {
        $query =
            static::find()
            ->select(['goods.id', 'name', 'price', 'image', 'date'])
            ->where('goods.amount > 0')
            ->distinct();

        return $query->orderBy('date DESC');
    }

    public function search($params)
    {
        $query = static::find()
            ->select(['goods.id', 'name', 'price', 'image', 'date'])
            ->innerJoinWith('categoriesRelations')
            ->where('goods.amount > 0')
            ->distinct();

        if ($params['id_cat']) {
            $query->andFilterWhere(['=', 'id_cat', $params['id_cat']]);
        }

        if ($params['search']) {
            $query->andFilterWhere(['like', 'name', $params['search']]);
        }

        if ($params['price-search']) {
            $range = explode(',', $params['price-search']);
            $query->andFilterWhere(['between', 'price', $range[0], $range[1]]);
        }

        return $query->orderBy('date DESC');
    }

    public function getRecommendationsList($criteria)
    {
        return
            static::find()
                ->select(['id', 'name', 'image', 'price', 'date', 'views'])
                ->where('goods.amount > 0')
                ->orderBy($criteria)
                ->limit(4)
                ->all();
    }

    public function getSimilarGoods()
    {
        $categories = [];

        foreach ($this->getCategories() as $key => $value) {
            $categories[] = $key;
        }

        $cats = implode(',', $categories);

        $query = static::find()
            ->select(['goods.id', 'name', 'image', 'price'])
            ->where(['<>', 'goods.id', $this->id]);

        if ($categories) {
            return $query
                ->innerJoin('categories_relation', 'categories_relation.id_good = goods.id')
                ->andWhere(['in', 'id_cat', $cats])
                ->asArray()
                ->all();
        }

        return [];
    }

    public function getImage()
    {
        if ($this->image) {
            return Yii::$app->storage->getFile($this->image);
        }
        return Yii::$app->storage->getFile(Storage::DEFAULT_IMAGE);
    }

    public function getDescription()
    {
        if ($this->description) {
            return $this->description;
        }

        return $this->name;
    }

    public static function getMaxPrice()
    {
        return static::find()->max('price');
    }

    public function updateViews()
    {
        $this->views++;
        return $this->save(false, ['views']);
    }

    public function viewedBy()
    {
        $ip = Yii::$app->request->userIP;
        $viewed = time();
        $expire = $viewed + self::TIME;

        if ($model = RecentViews::findOne(['user_ip' => $ip, 'id_good' => $this->id])) {
            $model->viewed = $viewed;
            $model->expire = $expire;
        } else {
            $model = new RecentViews([
                'user_ip' => $ip,
                'id_good' => $this->id,
                'viewed' => $time = time(),
                'expire' => $time + self::TIME
            ]);
        }
        return $model->save();
    }
}
