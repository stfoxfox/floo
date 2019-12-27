<?php

namespace backend\widgets\editable;

use common\SharedAssets\EditableAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class EditableWidget extends Widget
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $pk;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $placeholder = '';

    /**
     * @var string
     */
    public $mode = 'inline';

    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $source;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        $options = ArrayHelper::merge([
            'data-name' => $this->name,
            'data-value' => $this->value,
            'data-pk' => $this->pk,
            'data-url' => Url::to($this->url),
            'data-emptytext' => Yii::t('yii', '(not set)'),
            'data-mode' => $this->mode,
            'data-type' => $this->type,
            'data-placement' => 'right',
            'data-placeholder' => $this->placeholder ? $this->placeholder : null,
            'class' => 'editable editable-click item-settings myeditable save-item',
            'data-original-title' => '',
            'title' => '',
            'style' => 'background-color: rgba(0, 0, 0, 0);',
        ], $this->options);

        if ($this->source) {
            $options['source'] = $this->source;
        }

        EditableAsset::register($this->view);

        return Html::a(Html::encode($this->value), '#', $options);
    }

}