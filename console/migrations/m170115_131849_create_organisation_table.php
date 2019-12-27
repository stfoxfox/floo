<?php

use yii\db\Migration;

/**
 * Handles the creation of table `organisation`.
 */
class m170115_131849_create_organisation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('organisation', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'sber_user'=>$this->string(),
            'sber_pass'=>$this->string(),
            'platron_user'=>$this->string(),
            'platron_pass'=>$this->string(),
            'created_at'=>$this->timestamp()->defaultExpression('NOW()'),
            'updated_at'=>$this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->addColumn('restaurant','organisation_id',$this->integer());

        $this->addForeignKey('restaurant-organisation_id-fkey','restaurant','organisation_id','organisation','id',"SET NULL","CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropForeignKey('restaurant-organisation_id-fkey','restaurant');
        $this->dropColumn('restaurant','organisation_id');
        $this->dropTable('organisation');
    }
}
