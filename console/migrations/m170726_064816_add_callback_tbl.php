<?php

use yii\db\Migration;

class m170726_064816_add_callback_tbl extends Migration
{
    public function up()
    {
        $this->createTable('callback', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'phone'=>$this->string()->notNull(),
            'user_id'=>$this->integer(),
            'active'=>$this->boolean()->notNull()->defaultValue(true),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")

        ]);

        $this->addForeignKey('callback-user_id-fkey','callback','user_id','user','id','SET NULL','SET NULL');
        $this->createIndex('callback-user_id-idx','callback','user_id');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('callback-user_id-fkey','callback');
        $this->dropIndex('callback-user_id-idx','callback');
        $this->dropTable('callback');
    }
}
