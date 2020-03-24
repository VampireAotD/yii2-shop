<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m200319_122914_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_good' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'date' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'description' => $this->string(255)
        ]);

        $this->createIndex(
            'idx-orders-id_user',
            'orders',
            'id_user'
        );

        $this->createIndex(
          'idx-orders-id_good',
          'orders',
          'id_good'
        );

        $this->addForeignKey(
          'fk-orders-id_user',
          'orders',
          'id_user',
          'user',
          'id',
          'cascade'
        );

        $this->addForeignKey(
          'fk-orders-id_good',
          'orders',
          'id_good',
          'goods',
          'id',
          'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
