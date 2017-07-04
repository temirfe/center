<?php

use yii\db\Migration;

class m170704_062243_addcol_author_article extends Migration
{
    public function up()
    {
        $this->addColumn('article','custom_author','varchar(255) NOT NULL');
    }

    public function down()
    {
        echo "m170704_062243_addcol_author_article cannot be reverted.\n";

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
