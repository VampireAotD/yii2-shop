<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m200406_134406_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'id_good' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
          'idx-subscription-id_good',
          'subscription',
          'id_good'
        );

        $this->addForeignKey(
          'fk-subscription-id_good',
          'subscription',
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
        $this->dropTable('{{%subscription}}');
    }
}
