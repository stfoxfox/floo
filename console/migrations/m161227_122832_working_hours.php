<?php

use yii\db\Migration;

class m161227_122832_working_hours extends Migration
{
    public function up()
    {

        $this->createTable('working_days',
            array(

                'id'=>$this->primaryKey(),
                'weekday'=>$this->smallInteger()->notNull(),
                'status'=>$this->smallInteger()->notNull(),
                'created_at'=>$this->timestamp()->defaultExpression("now()"),
                'updated_at'=>$this->timestamp()->defaultExpression("now()")

            ));



        $this->createTable('working_hours', array(
            'id'=>$this->primaryKey(),
            'open_time'=>$this->time(),
            'close_time'=>$this->time(),
            'type'=>$this->smallInteger()->notNull()->defaultValue(1),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ));


        $this->addColumn('working_days','restaurant_id',$this->integer()->notNull());

        $this->addForeignKey('working_days-restaurant_id-fkey','working_days','restaurant_id','restaurant','id','CASCADE','CASCADE');



        $this->addColumn('working_hours','working_day_id',$this->integer());

        $this->addForeignKey('working_hours_working_day_id_fkey','working_hours','working_day_id','working_days','id','CASCADE','CASCADE');


        $this->createIndex('working_hours-working_day_id-idx','working_hours','working_day_id');
        $this->createIndex('working_days-restaurant_id-idx','working_days','restaurant_id');
    }

    public function down()
    {


        $this->dropTable('working_hours');
        $this->dropTable('working_days');
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
