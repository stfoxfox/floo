<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\editable\EditableWidget;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
?>

<?=GridView::widget([
    'dataProvider' => $models,
    'tableOptions' => ['class' => 'table table-hover'],
    'layout' => "{items}\n{pager}",
    'columns' => [
        'title', 'text_key',
        [
            'label' => 'Значение',
            'format' => 'raw',
            'value' => function($model) {
                /** @var $model \common\models\SiteSettingsSearch */
                if ($model->isBaseType()) {
                    return EditableWidget::widget([
                        'type' => $model->getEditableType(),
                        'value' => $model->getValue(),
                        'pk' => $model->id,
                        'url' => ['item-edit'],
                    ]);
                }

                return $model->getValue();
            }
        ],
        [
            'header' => 'Действия',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {settings}',
            'buttons' => [
                'update' => function ($url, $model) {
                    /** @var $model \common\models\SiteSettingsSearch */
                    if ($model->isBaseType() || ($model->type == \common\models\SiteSettings::SiteSettings_TypeArray))
                        return '';

                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                },
                'settings' => function ($url, $model) {
                    /** @var $model \common\models\SiteSettingsSearch */
                    if ($model->type <> \common\models\SiteSettings::SiteSettings_TypeArray)
                        return '';

                    return Html::a('<span class="glyphicon glyphicon-cog"></span> Настройки', ['items', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                }
            ],
        ],
    ]
])?>

