<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Site controller
 */
class BaseController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                $user = Yii::$app->user->identity;
                                return $user && $user->is_admin;
                            }
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        Yii::$app->session->setFlash('error', 'У вас нет доступа');
                        return $this->goHome();
                    },
                ],
            ];
    }

    function init()
    {
        parent::init();

        if (Yii::$app->request->isAjax) return;

        $menuItems = [
            ["label" => "Пользователи", "url" => ["user/index"], "icon" => "users"],
            ["label" => "Новости", "url" => ["news/index"], "icon" => "newspaper-o"],
            ["label" => "Категории", "url" => ["category/index"], "icon" => "server"],
            ["label" => "Комментарии", "url" => ["comment/index"], "icon" => "comments"],
        ];

        $this->view->params = [
            'menuItems' => $menuItems,
        ];
    }

}
