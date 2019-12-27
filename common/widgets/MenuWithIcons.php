<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets;

use Yii;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class MenuWithIcons extends Menu
{


    public $linkTemplateWithIcon ='<a href="{url}">{label}</a>' ;
    public $linkTemplateWithIconParent ='<a href="{url}"><i class="fa fa-fw {icon}"></i> <span class="menu-item-parent">{label}</span></a>' ;
    public $linkTemplateWithOutIconParent ='<a href="{url}"><span class="menu-item-parent">{label}</span></a>' ;
    public $submenuTemplate = "\n<ul class='nav nav-second-level collapse'>\n{items}\n</ul>\n";
    public $isForBackend=false;
    public $forceActive = false;

    protected function renderItem($item)
    {

        if (!isset($item['url'])) {
            $url="#";
        }else
            $url= $item['url'];


        if (!isset($item['icon'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplateWithOutIconParent);
            return strtr($template, [
                '{url}' => Html::encode(Url::to($url)),
                '{label}' => $item['label'],
            ]);
        }else {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplateWithIconParent);
            return strtr($template, [
                '{url}' => Html::encode(Url::to($url)),
                '{label}' => $item['label'],
                '{icon}' => $item['icon'],

            ]);
        }


    }

    public function run()
    {
        if($this->isForBackend){
           parent::run();
        }
        else {
            if ($this->route === null && Yii::$app->controller !== null) {
                $this->route = Yii::$app->controller->getRoute();
            }
            if ($this->params === null) {
                $this->params = Yii::$app->request->getQueryParams();
            }
            $items = $this->normalizeItems($this->items, $hasActiveChild);
            if (!empty($items)) {
                $options = $this->options;
                $tag = ArrayHelper::remove($options, 'tag', '');
                echo $this->renderItems($items);
            }
        }
    }


    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }

        return implode("\n", $lines);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = Yii::getAlias($item['url'][0]);



            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }




            if($this->forceActive && $this->forceActive == $route){
               return true;
            }


            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count(     $item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }


}