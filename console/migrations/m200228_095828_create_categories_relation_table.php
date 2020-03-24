<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_relation}}`.
 */
class m200228_095828_create_categories_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_relation}}', [
            'id' => $this->primaryKey(),
            'id_cat' => $this->integer(),
            'id_good' => $this->integer()
        ]);

        $this->createIndex('idx-categories_relation-id_cat','{{%categories_relation}}','id_cat');
        $this->addForeignKey('fk-categories_relation-id_cat','{{%categories_relation}}','id_cat','categories','id','cascade');

        $this->createIndex('idx-categories_relation-id_good','{{%categories_relation}}','id_good');
        $this->addForeignKey('fk-categories_relation-id_good','{{%categories_relation}}','id_good','goods','id','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories_relation}}');
    }
}
