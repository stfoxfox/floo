<?php

use yii\db\Migration;

class m161202_160733_init_api extends Migration
{
    public function safeUp()
    {

        $this->createTable("api_token",
            [

                'token'=>'UUID unique DEFAULT gen_random_uuid()',
                'device_type'=>$this->smallInteger()->defaultValue(0),
                'device_token'=>$this->text(),
                'lang'=>$this->string(10),
                'created_at'=>$this->timestamp()->defaultValue('NOW()'),
                'updated_at'=>$this->timestamp()->defaultValue('NOW()'),
                'PRIMARY KEY(token)'

            ]
        );


        $this->createTable('user_auth',
            [

                'user_token'=>'UUID unique DEFAULT gen_random_uuid()',
                'api_token_uuid'=>'UUID',
                'user_id'=>$this->integer(),
                'created_at'=>$this->timestamp()->defaultValue('NOW()'),
                'updated_at'=>$this->timestamp()->defaultValue('NOW()'),
                'PRIMARY KEY(api_token_uuid, user_id)'

            ]);


        $this->addForeignKey('user_auth-user_id-fkey','user_auth','user_id','user','id','CASCADE','CASCADE');
        $this->addForeignKey('user_auth-api_token_uuid-fkey','user_auth','api_token_uuid','api_token','token','CASCADE','CASCADE');
        $this->createIndex('idx-user_auth-user_id','user_auth','user_id');




        $this->createIndex('idx-user_auth-user_token','user_auth' ,'user_token',true);


    }

    public function safeDown()
    {

        $this->dropTable('user_auth');
        $this->dropTable('api_token');
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
