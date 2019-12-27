<?php

namespace backend\models\forms;

use Yii;
use common\components\MyExtensions\MyFileSystem;
use common\models\CatalogItemModificatorCountLink;
use yii\base\Model;

class CatalogItemModificatorForm extends Model
{
    public $catalog_item_id;
    public $catalog_item_modificator_id;
    public $count;

    public function rules()
    {
        return [
            [['catalog_item_id', 'catalog_item_modificator_id', 'count'], 'integer'],
        ];
    }

    public function loadFromItem($item){
        $this->catalog_item_id = $item->catalog_item_id;
        $this->catalog_item_modificator_id = $item->catalog_item_modificator_id;
        $this->count = $item->count;
    }

    public function save(){

        if ($this->validate()) {

            $item = new CatalogItemModificatorCountLink();

            $item->catalog_item_id = $this->catalog_item_id;
            $item->catalog_item_modificator_id = $this->catalog_item_modificator_id;
            $item->count = $this->count;

            if ($item->save()){
                return $item;
            }
        }

        return false;
    }

    public function edit(){

        if ($this->validate()) {

            $item = CatalogItemModificatorCountLink::findOne(['catalog_item_id' => $this->catalog_item_id, 'catalog_item_modificator_id' => $this->catalog_item_modificator_id]);
            if($item){
                $item->catalog_item_id = $this->catalog_item_id;
                $item->catalog_item_modificator_id = $this->catalog_item_modificator_id;
                $item->count = $this->count;

                if ($item->save()){
                    return $item;
                }
            }
        }

        return false;
    }

}