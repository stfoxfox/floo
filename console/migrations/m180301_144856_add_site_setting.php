<?php

use yii\db\Migration;
use common\models\Setting;
/**
 * Class m180301_144856_add_site_setting
 */
class m180301_144856_add_site_setting extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $setting = new Setting([
            'title' => 'Тег H1',
            'key' => 'tag_h1',
            'type' => 'text',
            'value' => 'some text'
        ]);
        $setting->save();
        Setting::setItemInCache([$setting->key => $setting->value]);

        $setting = new Setting([
            'title' => 'Тег H2',
            'key' => 'tag_h2',
            'type' => 'text',
            'value' => 'some text'
        ]);
        $setting->save();
        Setting::setItemInCache([$setting->key => $setting->value]);

        $setting = new Setting([
            'title' => 'Тег H3',
            'key' => 'tag_h3',
            'type' => 'text',
            'value' => 'some text'
        ]);
        $setting->save();
        Setting::setItemInCache([$setting->key => $setting->value]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
    }
}
