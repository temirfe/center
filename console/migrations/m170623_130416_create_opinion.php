<?php

use yii\db\Migration;

class m170623_130416_create_opinion extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('opinion', [
            'id' => $this->primaryKey(),
            'name' => $this->string('50')->notNull(),
            'title' => $this->string('100')->notNull(),
            'description' => $this->string('500')->notNull(),
            'image' =>$this->string('200')->notNull(),
            'expert_id' =>$this->integer('11'),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m170623_130416_create_opinion cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
