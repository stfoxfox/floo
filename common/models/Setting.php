<?php


namespace common\models;


use common\models\BaseModels\SettingBase;
use common\widgets\SettingEnum;
use Yii;

class Setting extends SettingBase
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            SettingEnum::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        try {
            return parent::save($runValidation, $attributeNames);
        } catch (\yii\db\Exception $e) {
            SettingEnum::add($this->type);
            return parent::save($runValidation, $attributeNames);
        }
    }

    public function uploadTo($attribute){
        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/setting/{$this->$attribute}";
        else
            return null;
    }

    public static function getSettingCache(){
        $settingCache = Yii::$app->cache->get('setting');
        if($settingCache === false){
            $settingCache = [];
        }
        return $settingCache;
    }

    public static function getValueByKey($key){
        $settingCache = self::getSettingCache();
        if($settingCache !== false){
            foreach($settingCache as $setting){
                if(array_key_exists($key, $setting)){
                    return $setting[$key];
                }
            }
        }
        return false;
    }

    public static function setItemInCache($item){
        $isUpdate = false;
        $settingCache = self::getSettingCache();
        if($settingCache !== false){
            foreach($settingCache as $key => $setting){
                if(array_key_exists(key($item), $setting)){
                    $settingCache[$key] = $item;
                    $isUpdate = true;
                }
            }
        }
        if(!$isUpdate){
            $settingCache[] = $item;
        }
        Yii::$app->cache->set('setting', $settingCache);
    }

    public static function dropItemFromCache($item){
        $settingCache = self::getSettingCache();
        if($settingCache !== false){
            foreach($settingCache as $key => $setting){
                if(array_key_exists(key($item), $setting)){
                    unset($settingCache[$key]);
                    sort($settingCache);
                }
            }
        }        
        Yii::$app->cache->set('setting', $settingCache);
    }
}