<?php

use yii\db\Migration;

/**
 * Class m200415_171959_add_test_data_categories_relation_table
 */
class m200415_171959_add_test_data_categories_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rows = [];

        for ($i = 1; $i <= 20; $i++) {
            $rows[] = [
                rand(1, 18),
                rand(1, 150)
            ];
        }

        $this->batchInsert('{{%categories_relation}}', [
            'id_cat',
            'id_good'
        ], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%categories_relation}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200415_171959_add_test_data_categories_relation_table cannot be reverted.\n";

        return false;
    }
    */
}
