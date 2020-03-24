<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%recent_views}}`.
 */
class m200320_122355_create_recent_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%recent_views}}', [
            'id' => $this->primaryKey(),
            'user_ip' => $this->string(),
            'id_good' => $this->integer(),
            'viewed' => $this->integer(),
            'expire' => $this->integer()
        ]);

        $this->createIndex(
            'idx-recent_views-id_good',
            'recent_views',
            'id_good'
        );

        $this->addForeignKey(
          'fk-recent_views-id_good',
          'recent_views',
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
        $this->dropTable('{{%recent_views}}');
    }
}
