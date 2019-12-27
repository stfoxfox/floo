<?php

use yii\db\Migration;
use common\models\SiteSettings;

/**
 * Class m180412_065710_add_settings
 */
class m180412_065710_add_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // parent settings
        $orderSetting = new SiteSettings([
            'title' => 'Настройки заказа',
            'text_key' => 'order_settings',
            'type' => SiteSettings::SiteSettings_TypeArray,
        ]);

        $orderSetting->save();
        SiteSettings::setItemInCache([$orderSetting->text_key => $orderSetting->string_value]);

        $pointSetting = new SiteSettings([
            'title' => 'Настройки баллов',
            'text_key' => 'point_settings',
            'type' => SiteSettings::SiteSettings_TypeArray,
        ]);

        $pointSetting->save();
        SiteSettings::setItemInCache([$pointSetting->text_key => $pointSetting->string_value]);

        // child order settings
        $setting = new SiteSettings([
            'title' => 'Максимальный процент списывания',
            'text_key' => 'max_percent_of_write',
            'type' => SiteSettings::SiteSettings_TypeNumber,
            'number_value' => 100,
            'parent_id' => $orderSetting->id
        ]);

        $setting->save();
        SiteSettings::setItemInCache([$setting->text_key => $setting->number_value]);

        $setting = new SiteSettings([
            'title' => 'Минимальный заказ',
            'text_key' => 'min_order',
            'type' => SiteSettings::SiteSettings_TypeNumber,
            'number_value' => 100,
            'parent_id' => $orderSetting->id
        ]);

        $setting->save();
        SiteSettings::setItemInCache([$setting->text_key => $setting->number_value]);

        // child point settings
        $setting = new SiteSettings([
            'title' => 'Минимальный заказ для начисления',
            'text_key' => 'min_order_for_profit',
            'type' => SiteSettings::SiteSettings_TypeNumber,
            'number_value' => 100,
            'parent_id' => $pointSetting->id
        ]);

        $setting->save();
        SiteSettings::setItemInCache([$setting->text_key => $setting->number_value]);

        $setting = new SiteSettings([
            'title' => 'Процент начисления',
            'text_key' => 'profit_percent',
            'type' => SiteSettings::SiteSettings_TypeNumber,
            'number_value' => 100,
            'parent_id' => $pointSetting->id
        ]);

        $setting->save();
        SiteSettings::setItemInCache([$setting->text_key => $setting->number_value]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180412_065710_add_settings cannot be reverted.\n";

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180412_065710_add_settings cannot be reverted.\n";

        return false;
    }
    */
}
