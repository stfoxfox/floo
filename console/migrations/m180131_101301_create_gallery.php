<?php

use yii\db\Migration;

/**
 * Class m180131_101301_create_gallery
 */
class m180131_101301_create_gallery extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'text' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('gallery');
    }

}
