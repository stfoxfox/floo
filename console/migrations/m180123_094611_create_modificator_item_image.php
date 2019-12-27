<?php

use yii\db\Migration;

/**
 * Class m180123_094611_create_modificator_item_image
 */
class m180123_094611_create_modificator_item_image extends Migration
{
    public function safeUp()
    {
        $this->createTable('modificator_item_image', array(
            'id' => $this->primaryKey(),
            'modificator_item_id' => $this->integer(),
            'sort' => $this->integer(),
            'file_name' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ));
        $this->createIndex('modificator_item_image-page_id-idx', 'modificator_item_image', 'modificator_item_id');
        $this->addForeignKey('modificator_item_image-page_id-fkey', 'modificator_item_image', 'modificator_item_id', 'catalog_item_modificator', 'id', 'CASCADE', 'CASCADE');
     }

    public function safeDown()
    {
        echo "m170802_171352_add_modificator_item_gallery cannot be reverted.\n";

        return false;
    }

}
