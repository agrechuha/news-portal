<?php

use app\widgets\Alert;
use yii\widgets\Breadcrumbs;

/* @var $content string */

?>
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="content-wrapper">
        <section class="content-header">
            <?=
            Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            ) ?>
        </section>

        <section class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </section>
    </div>
</div>
