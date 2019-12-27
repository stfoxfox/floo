<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m161218_204103_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'address'=>$this->string()->notNull(),
            'entrance'=>$this->string(),
            'floor'=>$this->string(),
            'flat'=>$this->string(),
            'lat'=>'double  NOT NULL',
            'lng'=>'double  NOT NULL',
            'location'=>'GEOMETRY(POINT, 4326) NOT NULL',
            'created_at'=>$this->timestamp()->defaultExpression('NOW()'),
            'updated_at'=>$this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->createIndex('address-user_id-idx','address','user_id');

        $this->addForeignKey('address-user_id-fkey','address','user_id','user','id','CASCADE','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
