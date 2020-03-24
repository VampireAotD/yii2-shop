<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods}}`.
 */
class m200227_143711_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods}}', [
            'id' => $this->primaryKey(),
            'meta_title' => $this->string(255)->notNull(),
            'meta_description' => $this->text(),
            'meta_keywords' => $this->string(255),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(12,2)->notNull(),
            'amount' => $this->integer(),
            'date' => $this->date()->notNull(),
            'image' => $this->string(255),
            'views' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%goods}}');
    }
}
