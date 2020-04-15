<?php

use yii\db\Migration;

/**
 * Class m200415_171942_add_test_data_categories_table
 */
class m200415_171942_add_test_data_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        $rows = [];

        for ($i = 1; $i <= 15; $i++) {
            $rows[] = [
                $faker->name,
            ];
        }

        $this->batchInsert('{{%categories}}', [
            'name'
        ], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%categories}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200415_171942_add_test_data_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
