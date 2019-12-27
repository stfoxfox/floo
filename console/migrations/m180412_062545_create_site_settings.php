<?php

use yii\db\Migration;

/**
 * Class m180412_062545_create_site_settings
 */
class m180412_062545_create_site_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('site_settings', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'text_key'=>$this->string(),
            'type'=>$this->integer(),
            'bool_value'=>$this->boolean(),
            'string_value'=>$this->text(),
            'text_value'=>$this->text(),
            'text2_value'=>$this->text(),
            'file_name'=>$this->string(),
            'sort'=>$this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'number_value'=>$this->integer(),
            'parent_id'=>$this->integer(),
            'child_elements_type'=>$this->integer(),
            'model_id' => $this->integer(),
            'model_class'=> $this->string()
        ]);

        $this->createIndex('site_settings-parent_id-idx','site_settings','parent_id');
        $this->addForeignKey('site_settings-parent_id-fkey','site_settings','parent_id','site_settings','id','CASCADE','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('site_settings-parent_id-fkey','site_settings');
        $this->dropTable('site_settings');
    }

}
