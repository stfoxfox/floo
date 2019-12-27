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

class EditCatalogCategoryForm extends Model
{


    public $title;
    public $alias;
    public $show_in_app=true;
    public $is_active;
    public $is_main_page;


    public function rules()
    {
        return [

            [['title', 'alias'], 'required'],
            ['title', 'filter', 'filter' => 'trim'],
            [['show_in_app', 'is_active', 'is_main_page'], 'boolean'],
            ['show_in_app','safe'],
            ['alias','string'],


        ];
    }



    public function editCategory($category){

        if ($this->validate()){


            $category->title = $this->title;
            $category->alias = $this->alias;
            $category->show_in_app = $this->show_in_app;
            $category->is_active = $this->is_active;
            $category->is_main_page = $this->is_main_page;

            if ($category->save()){
                return true;
            }


        }


        return false;
    }


    public function attributeLabels()
    {
        return [

            'title' => 'Название',
            'alias' => 'Название в адресной строке',
            'show_in_app' => 'Отображать категорию в приложении',
            'is_active' => 'Активна',
            'is_main_page' => 'Отображать на главной странице'
        ];
    }

}