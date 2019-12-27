<?php

namespace common\widgets;

use tigrov\pgsql\enum\EnumBehavior;

class SettingEnum extends EnumBehavior
{
    /**
     * @var array list of attributes
     */
    public $attributes = ['type_name' => 'type_code'];

    /**
     * Values of setting
     * @return array
     */
    public static function values()
    {
        return [
            'string' => 'Строка',
            'text' => 'Текст',
            'boolean' => 'Булево значение',
            'image' => 'Картинка',
        ];
    }
}
?>