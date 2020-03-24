<?php

use yii\db\Migration;

/**
 * Class m200308_131331_alter_slide_table
 */
class m200308_131331_alter_slide_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%slide}}','status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slide}}','status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200308_131331_alter_slide_table cannot be reverted.\n";

        return false;
    }
    */
}
