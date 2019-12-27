<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;


use common\models\CatalogCategory;
use yii\base\Model;

class AddCatalogCategoryForm extends Model
{


    public $title;
    public $alias;


    public function rules()
    {
        return [

            [['title','alias'], 'required'],
            ['title', 'filter', 'filter' => 'trim'],
            ['alias', 'string'],
            ['alias', 'unique', 'targetClass' => 'common\models\CatalogCategory', 'message' => 'Алиас уже занят'],
        ];
    }



    public function createCategory(){

        if ($this->validate()){

            $newCategory = new CatalogCategory();

            $newCategory->title=$this->title;
            $newCategory->alias=$this->alias;

            if ($newCategory->save()){

                return $newCategory;
            }


        }


        return false;
    }

}