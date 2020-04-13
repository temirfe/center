<?php

use yii\db\Migration;

/**
 * Class m200412_112248_project
 */
class m200412_112248_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull(),
            'text' => $this->text(),
            'image' => $this->string('200'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200412_112248_project cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200412_112248_project cannot be reverted.\n";

        return false;
    }
    */
}
