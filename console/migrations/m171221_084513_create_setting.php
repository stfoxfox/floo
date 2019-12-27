<?php

use yii\db\Migration;
use common\widgets\SettingEnum;

/**
 * Class m171221_084513_create_setting
 */
class m171221_084513_create_setting extends Migration
{
    public function up()
    {
        SettingEnum::create(['string', 'boolean', 'text', 'image']);
        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'key' => $this->text()->notNull(),
            'type' => SettingEnum::typeName(),
            'value' => $this->text()->notNull(),
        ]);

        $this->createIndex('key-idx','setting','key');
    }

    public function down()
    {
        $this->dropTable('setting');
    }
}
