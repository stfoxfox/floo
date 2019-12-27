<?php

use yii\db\Migration;

class m161203_235600_user_fix extends Migration
{
    public function up()
    {


        $this->execute('ALTER TABLE "user" ALTER COLUMN email DROP NOT NULL;');
    }

    public function down()
    {
        echo "m161203_235600_user_fix cannot be reverted.\n";

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
