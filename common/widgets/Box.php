<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Widget;

/**
 * Class Box
 * @package common\widgets
 */
class Box extends Widget
{
    /**
     * @var string the header content
     */
    public $header;

    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];

    public $headerButtons = [];

    public $fileButton = null;

    public $toolButtons = [];

    /**
     * @var string the footer content in the modal window.
     */
    public $footer;

    /**
     * @var string additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions =[];

    public $closeButton = false;

    public $collapseButton = true;

    public $bodyOptions;

    /**
     * Removes all padding inside widget body
     * @var bool
     */
    public $noPadding;

    public $tools;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();
        $this->_setNoPadding();
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";

    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderBodyEnd() . "\n";
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div');
        //$this->registerPlugin('modal');
    }

    /**
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $tools = $this->renderTools();
        if ($this->header !== null) {
            $header = Html::tag('h5', "\n" . $this->header . "\n", $this->headerOptions) . "\n" . ($tools !== null ? $tools : '');
            return Html::tag('div', $header, ['class' => 'ibox-title']);
        } else {
            return null;
        }
    }

    /**
     * Renders the opening tag of the ibox body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the ibox body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    /**
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, ['class' => 'ibox-footer']);
            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the tools
     * @return string the rendering result
     */
    protected function renderTools()
    {
        $tools = '';
        if (!empty($this->headerButtons) || !empty($this->fileButton)) {
            $tools .= Html::beginTag('div', ['class' => 'btn-group']);
            if (!empty($this->fileButton)) {
                $tools .= $this->fileButton;
            }

            if (!empty($this->headerButtons)) {
                foreach ($this->headerButtons as $button) {
                    $tools .= Html::a(isset($button['label']) ? $button['label'] : '',
                        isset($button['url']) ? $button['url'] : 'javascript:void(0)',
                        $button['options']
                    );
                }
            }
            $tools .= Html::endTag('div');
        }

        if (!empty($this->toolButtons)) {
            foreach ($this->toolButtons as $button) {
                $tools .= Html::a(isset($button['label']) ? $button['label'] : '',
                    isset($button['url']) ? $button['url'] : 'javascript:void(0)',
                    $button['options']
                );
            }
        }

        if($this->collapseButton !== false){
            $tools .= '<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>';
        }
        if ($this->closeButton !== false) {
            $tools .= '<a class="close-link"><i class="fa fa-times"></i></a>';
        }
        if (!empty($tools)) {
            return Html::tag('div', $tools, ['class' => 'ibox-tools']);
        } else {
            return null;
        }
    }

    /**
     * Set no padding
     */
    private function _setNoPadding()
    {
        if ($this->noPadding !== null) {
            Html::addCssClass($this->bodyOptions, 'no-padding');
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge([
            'class' => 'ibox float-e-margins',
            'tabindex' => -1,
        ], $this->options);

        Html::addCssClass($this->bodyOptions, 'ibox-content');
    }
}