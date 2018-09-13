<?php

use yii\db\Migration;

class m170105_094713_create_video extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('video', [
            'id' => $this->primaryKey(),
            'title' => $this->string('500')->notNull(),
            'description' => $this->string('1000')->notNull(),
            'link' => $this->string('100')->notNull(),
            'thumb' => $this->string('100')->notNull(),
            'video_id' => $this->string('30')->notNull(),
            'views' => $this->integer('11')->notNull()->defaultValue(0),
            'date_create'=>$this->timestamp(),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m170105_094713_create_video cannot be reverted.\n";

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
