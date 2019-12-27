<?php

use yii\db\Migration;

class m171210_114426_review extends Migration
{
    public function up()
    {

        $this->createTable('review',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'review_text'=>$this->text()->notNull(),
            'phone'=>$this->string()->notNull(),
            'file_name'=>$this->string(),
            'is_active' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()

        ]);


    }

    public function down()
    {
       $this->dropTable('review');
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
