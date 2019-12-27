<?php
namespace frontend\widgets;

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 10/12/2017
 * Time: 17:05
 */

class LinkPager extends \yii\widgets\LinkPager
{

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('a', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::a($label, $this->pagination->createUrl($page), $options);
    }
}