<?php

namespace backend\models;

use Elasticsearch\ClientBuilder;
use Yii;
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
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    public $categories;

    const DEFAULT_IMAGE = 'no-image.jpg';

    private $builder;

    public function init()
    {
        parent::init();
        $this->builder = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterUpdate']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_title', 'name', 'price'], 'required'],
            [['meta_description', 'description'], 'string'],
            [['price'], 'number'],
            [['amount', 'views'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            ['date', 'default', 'value' => date('Y-m-d')],
            [['meta_title', 'meta_keywords', 'name', 'image'], 'string', 'max' => 255],
            ['categories', 'safe'],
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

    public function getId()
    {
        return $this->id;
    }

    public function getImage()
    {
        if ($this->image) {
            return Yii::$app->storage->getFile($this->image);
        }

        return Yii::$app->storage->getFile(self::DEFAULT_IMAGE);
    }

    public function beforeDelete()
    {
        Yii::$app->storage->deletePreviousImage($this->image);
        return parent::beforeDelete();
    }

    public function getCategories()
    {
        $categories = Categories::find()->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }

    public function getCurrentCategories()
    {
        $categories = static::hasMany(Categories::class, ['id' => 'id_cat'])->viaTable('{{categories_relation}}', ['id_good' => 'id'])->asArray()->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }

    public function getSubscriptionRelation()
    {
        return static::hasMany(Subscription::class, ['id_good' => 'id'])->select(['id', 'email', 'id_good'])->all();
    }

    public function afterFind()
    {
        $categories = CategoriesRelation::find()->where(['id_good' => $this->getId()])->all();
        $this->categories = ArrayHelper::getColumn($categories, 'id_cat');
    }

    public function afterUpdate()
    {
        $users = $this->getSubscriptionRelation();
        $ids = ArrayHelper::getColumn($users, 'id_good');
        $good = static::find()->where(['id' => $ids])->select(['id', 'name'])->one();

        if ($users && $this->amount > 0) {
            /**
             * @var $user User
             */
            foreach ($users as $user) {
                Yii::$app->mailer->compose(['html' => 'subscriptions'], ['good' => $good, 'user' => $user])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($user->email)
                    ->setSubject('Новая партия Ваших любимых игр!')
                    ->send();
            }
            Subscription::deleteAll(['id' => ArrayHelper::getColumn($users, 'id')]);
        }

        $this->builder->update([
            'index' => 'products',
            'id' => 'product-' . $this->id,
            'body' => [
                'doc' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'description' => $this->description,
                    'price' => $this->price,
                    'date' => $this->date,
                    'image' => $this->image,
                ]
            ]
        ]);
    }

    public function saveCategories()
    {
        if ($this->categories) {
            CategoriesRelation::deleteAll(['id_good' => $this->getId()]);
            $transaction = Goods::getDb()->beginTransaction();
            if ($this->save()) {
                foreach ($this->categories as $category) {
                    $relation = new CategoriesRelation;
                    $relation->id_cat = $category;
                    $relation->id_good = $this->getId();
                    $relation->save();
                }
                $transaction->commit();
                return true;
            }
            $transaction->rollBack();
        }
        return true;
    }

    public static function getGoodsList()
    {
        $goods = static::find()->all();
        return ArrayHelper::map($goods, 'id', 'name');
    }
}
