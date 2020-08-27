<?php

use yii\db\Migration;

/**
 * Class m200415_171949_add_test_data_goods_table
 */
class m200415_171949_add_test_data_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        $rows = [];

        for ($i = 1; $i <= 150; $i++) {
            $rows[] = [
                $name = $faker->title,
                $faker->realText(rand(100, 300)),
                $faker->sentence(rand(10, 15)),
                $name,
                $faker->realText(rand(100, 500)),
                $faker->numberBetween(100, 500),
                $faker->numberBetween(0, 800),
                $faker->date('Y-m-d'),
                rand(0, 1) ? '02ab2825469425b9_1920xH_large.jpg' : 'maxresdefault.webp'
            ];
        }

        $this->batchInsert('{{%goods}}', [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'name',
            'description',
            'price',
            'amount',
            'date',
            'image'
        ], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%goods}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200415_171949_add_test_data_goods_table cannot be reverted.\n";

        return false;
    }
    */
}
