<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\MyExtensions\MyFilePublisher;
use common\widgets\Box;

/**
 * @var $this \yii\web\View
 * @var $formItem \backend\models\forms\SiteSettingsForm
 * @var $item \common\models\SiteSettings
 */

$this->title = $item->title;
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>

<div class="row">
    <div class="col-lg-5 col-md-5 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-file"></i> Файл'])?>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php echo $form->field($formItem, 'file_name')->fileInput()->label(false);
                if ($item->file_name) {
                    echo '<hr/>';
                    echo Html::a($item->file_name, (new MyFilePublisher($item))->getFileUrl('file_name'));
                }?>
            </div>
        </div>

        <hr/>
        <div class="row">
            <div class="col-lg-12 col-md-12 m-t">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs']) ?>
                </div>
            </div>
        </div>
        <?php Box::end()?>
    </div>
</div>

<?php ActiveForm::end()?>