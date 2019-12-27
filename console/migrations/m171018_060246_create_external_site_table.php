<?php

use yii\db\Migration;

/**
 * Handles the creation of table `external_site`.
 */
class m171018_060246_create_external_site_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('external_site', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'url'=>$this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('external_site');
    }
}
