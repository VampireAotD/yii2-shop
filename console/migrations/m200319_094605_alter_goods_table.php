<?php

use yii\db\Migration;

/**
 * Class m200319_094605_alter_goods_table
 */
class m200319_094605_alter_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{goods}}','views',$this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{goods}}','views',$this->integer()->notNull()->defaultValue(0));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200319_094605_alter_goods_table cannot be reverted.\n";

        return false;
    }
    */
}
