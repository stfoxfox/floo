<?php

use yii\db\Migration;

/**
 * Handles the creation of table `change_phone_request`.
 */
class m170102_213232_create_change_phone_request_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('change_phone_request', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(),
            'new_phone'=>$this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ]);

        $this->addForeignKey('change_phone_request-user_id-fkey','change_phone_request','user_id','user','id','CASCADE','CASCADE');
        $this->createIndex('change_phone_request-user_id-idx','change_phone_request','user_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('change_phone_request');
    }
}
