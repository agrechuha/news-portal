<?php

use yii\helpers\Html;
use yii\helpers\Url;

$userName = Yii::$app->user->identity ? Yii::$app->user->identity->name : 'Нет пользователя';
?>
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <?= $userName ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <?=
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Выйти', ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

</div>