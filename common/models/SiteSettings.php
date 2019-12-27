<?php
namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use common\models\BaseModels\SiteSettingsBase;
use common\components\MyExtensions\MyFilePublisher;
use common\components\MyExtensions\MyFileSystem;

/**
 * Class SiteSettings
 * @package common\models
 * @inheritdoc
 *
 * @var SiteSettings[] $childs
 */
class SiteSettings extends SiteSettingsBase
{
    const SiteSettings_TypeText=1;
    const SiteSettings_TypeBool=2;
    const SiteSettings_TypeNumber=3;
    const SiteSettings_TypeFile=4;
    const SiteSettings_TypeImage=5;
    const SiteSettings_TypeString=6;
    const SiteSettings_TypeArray=7;
    const SiteSettings_TypeModel=21;

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'text_key' => 'Строковый ключ',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        if ($this->text_key == 'base_import_path' && isset($changedAttributes['string_value'])) {
            if (!is_dir($this->string_value)) {
                mkdir($this->string_value, 0755, true);
                FileHelper::copyDirectory($changedAttributes['string_value'], $this->string_value);
            }
        }

        if ($this->text_key == 'pdf_template' && isset($changedAttributes['file_name'])) {
            $path = FileHelper::normalizePath(Yii::getAlias("@frontend/web/files/pdf/"));

            if (is_dir($path))
                MyFileSystem::removeAllInDir($path, $path);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param $attribute
     * @return null|string
     */
    public function uploadTo($attribute) {
        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/settings/{$this->$attribute}";

        return null;
    }

    /**
     * @return bool|string
     */
    public function getEditableType() {
        switch ($this->type) {
            case  self::SiteSettings_TypeBool:
                return "boolean";

            case self::SiteSettings_TypeString:
                return "text";

            case self::SiteSettings_TypeText:
                return "textarea";

            case self::SiteSettings_TypeNumber:
                return "number";

            default:
                return false;
        }
    }

    /**
     * @return bool
     */
    public function isBaseType() {
        switch ($this->type) {
            case self::SiteSettings_TypeBool:
            case self::SiteSettings_TypeString:
            case self::SiteSettings_TypeText:
            case self::SiteSettings_TypeNumber:
                return true;

            default:
                return false;
        }
    }

    /**
     * @return int|null|string
     */
    public function getValue() {
        switch ($this->type) {
            case self::SiteSettings_TypeArray:
                return "Набор элементов, перейдите в режим редактирования";

            case  self::SiteSettings_TypeBool:
                return $this->bool_value ? 'Да' : 'Нет';

            case self::SiteSettings_TypeString:
                return $this->string_value;

            case self::SiteSettings_TypeText:
                return $this->text_value;

            case self::SiteSettings_TypeNumber:
                return $this->number_value;

            case self::SiteSettings_TypeFile:
                return $this->file_name
                    ? Html::a($this->file_name, (new MyFilePublisher($this))->getFileUrl('file_name'), ['target' => '_blank'])
                    : null;

            default:
                return null;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds() {
        return $this->getSiteSettings();
    }

    /**
     * @param null $complex_id
     * @return array|null
     */
    public static function getMailTransport($complex_id = null){
        $host = self::getByKeyComplex('smtp_host', $complex_id);
        if (!$host || !$host->string_value) {
            return null;
        }

        $username = self::getByKeyComplex('smtp_username', $complex_id);
        if (!$username || !$username->string_value) {
            return null;
        }

        $password = self::getByKeyComplex('smtp_password', $complex_id);
        if (!$password || !$password->string_value) {
            return null;
        }

        $port = self::getByKeyComplex('smtp_port', $complex_id);
        if (!$port || !$port->string_value) {
            return null;
        }

        $encryption = self::getByKeyComplex('smtp_encryption', $complex_id);
        if (!$encryption || !$encryption->string_value) {
            return null;
        }

        return [
            'class' => 'Swift_SmtpTransport',
            'host' => $host->string_value,
            'username' => $username->string_value,
            'password' => $password->string_value,
            'port' => $port->string_value,
            'encryption' => $encryption->string_value,
        ];
    }

    /**
     * @param $key
     * @param null $complex_id
     * @return SiteSettings
     */
    public static function getByKeyComplex($key, $complex_id = null) {
        return self::find()->andWhere(['text_key' => $key])->andFilterWhere(['complex_id' => $complex_id])->one();
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
