<?php

use yii\db\Migration;

/**
 * Class m200412_112910_proj_items
 */
class m200412_112910_proj_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('project_items', [
            'id' => $this->primaryKey(),
            'item' => $this->string('255')->notNull(),
            'project_id' => $this->integer('11'),
            'item_id' => $this->integer('11'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200412_112910_proj_items cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200412_112910_proj_items cannot be reverted.\n";

        return false;
    }
    */
}
