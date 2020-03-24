<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slide}}`.
 */
class m200305_154950_create_slide_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%slide}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'id_good' => $this->integer(),
        ]);

        $this->createIndex('idx-slide-id_good','slide','id_good');
        $this->addForeignKey('fk-slide-id_good','slide','id_good','goods','id','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slide}}');
    }
}
