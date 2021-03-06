<?php

use yii\helpers\Url;
$userName = Yii::$app->user->identity ? Yii::$app->user->identity->name : 'Нет пользователя';
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>На главную</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu prile quick info -->
        <div class="profile" style="display: flex">
            <div class="profile_info">
                <span>Приветствуем,</span>
                <h2><?= $userName ?></h2>
            </div>
        </div>
        <!-- /menu prile quick info -->
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <?=
                \yiister\gentelella\widgets\Menu::widget(
                    [
                        'encodeLabels' => false,
                        "items" => $this->params['menuItems']
                    ]
                )
                ?>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>