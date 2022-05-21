<?php

namespace app\helpers;

use app\models\Category;
use yii\helpers\Url;

class MenuHelper extends \yii\helpers\ArrayHelper
{
    /**
     * @param $category Category
     * @param $action
     * @param $
     * @return string
     */
    public static function getHtmlCategoriesMenu(Category $category): string
    {
        $link = Url::toRoute(['/category/' . $category->name]);
        $menuItem = (!$category->parent_id ? '<ul>' : '') . '<li><a class="category-menu-link" href="' . $link . '" data-category="' .
            $category->name . '">' . $category->title . '</a>';

        if ($category->children) {
            $menuItem .= '<ul>';
            foreach ($category->children as $child) {
                $menuItem .= self::getHtmlCategoriesMenu($child);
            }
            $menuItem .= '</ul>';
        }
        $menuItem .= '</li>' . (!$category->parent_id ? '</ul>' : '');
        return $menuItem;
    }
}