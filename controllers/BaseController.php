<?php

namespace app\controllers;

use app\helpers\MenuHelper;
use app\models\Category;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Site controller
 */
class BaseController extends Controller
{
    function init()
    {
        parent::init();

        if (Yii::$app->request->isAjax) return;

        $menuItems = [
            ['label' => 'Главная', 'url' => ['/site/index']],
        ];

        $rootCategories = Category::findAll(['parent_id' => null]);

        if ($rootCategories) {
            $menuItemCategories = [
                'label' => 'Категории', 'url' => '#', 'items' => []
            ];
            foreach ($rootCategories as $rootCategory) {
                $rootCategory->populateTree();
                $menuItemCategories['items'][] = MenuHelper::getHtmlCategoriesMenu($rootCategory) ;
            }
            $menuItems[] = $menuItemCategories;
        }

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Авторизоваться', 'url' => ['/site/login']];
            $menuItems[] = ['label' => 'Зарегистрироваться', 'url' => ['/site/signup']];
        } else {
            if (Yii::$app->user->identity->is_admin) {
                $menuItems[] = ['label' => 'Кабинет администратора', 'url' => ['/admin']];
            }
            $menuItems[] = '<li class="logout">'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';


        }

        $this->view->params = [
            'menuItems' => $menuItems,
        ];
    }

}
