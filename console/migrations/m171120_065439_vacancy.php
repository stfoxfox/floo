<?php

use yii\db\Migration;

class m171120_065439_vacancy extends Migration
{
    public function up()
    {

        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'sort' => $this->integer(),
            'is_active' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);
        
        
        
        $this->createTable('vacancy_restaurant_link',[
            'vacancy_id'=>$this->integer()->notNull(),
            'restaurant_id'=>$this->integer()->notNull(),
                'PRIMARY KEY(vacancy_id, restaurant_id)'

        ]);

        $this->addForeignKey('vacancy_restaurant_link-vacancy_id-fkey','vacancy_restaurant_link','vacancy_id','vacancy','id','CASCADE','CASCADE');
        $this->addForeignKey('vacancy_restaurant_link-restaurant_id-fkey','vacancy_restaurant_link','restaurant_id','restaurant','id','CASCADE','CASCADE');
        $this->createIndex('idx-vacancy_restaurant_link-vacancy_id','vacancy_restaurant_link','vacancy_id');
        $this->createIndex('idx-vacancy_restaurant_link-restaurant_id', 'vacancy_restaurant_link', 'restaurant_id');


        $this->createTable('vacancy_response', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'info' => $this->string(),
            'file_name' => $this->string(),
            'vacancy_id' => $this->integer()->notNull() . ' REFERENCES vacancy(id)',
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);

    }

    public function down()
    {
        echo "m171120_065439_vacancy cannot be reverted.\n";

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
