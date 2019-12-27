<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 23:57
 */

use backend\assets\custom\CatalogAddCategoryAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;


$this->title ='Добавить категорию';


?>



<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">

                <h2><span class="text-success">Pronto24.ru</span><br>
                    Необходимо добавить первый регион</h2>


            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">

                <h2><span class="text-success">Добавить</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id'=>'add-category']);
                    ?>
                    <?= $form->field($addForm, 'title',array())->textInput()->label(false) ?>

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>

