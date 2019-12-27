<?php
use common\widgets\Box;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
?>

<div class="row">
    <div class="col-lg-12 col-md-12 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'collapseButton' => false
        ])?>

        <?=$this->render('_items', ['models' => $models])?>

        <?php Box::end()?>
    </div>
</div>

