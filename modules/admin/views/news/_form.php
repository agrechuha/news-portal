<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $text = '';
    if ($model->category_id) {
        $text = $model->category->name;
    }
    echo $form->field($model, 'category_id')->widget(kartik\select2\Select2::classname(), [
        'initValueText' => $text, // set the initial display text
        'options' => ['placeholder' => 'Поиск категории по названию ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Поиск...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['category/search-ajax']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(obj) { return obj.text; }'),
            'templateSelection' => new JsExpression('function (obj) { return obj.text; }'),
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'replaceDivs' => false,
            'linebreaks' => true,
            //            'pastePlainText' => true,
            'plugins' => [
                'clips',
                'counter',
                'definedlinks',
                'fontcolor',
                'fontfamily',
                'fontsize',
                'fullscreen',
                'table',
                'textdirection',
                'textexpander',
            ],
            'formattingAdd' => [
                [
                    'title' => 'Обратите внимание',
                    'tag' => 'span',
                    'class' => 'attention',
                ],
            ],
            'pasteBeforeCallback' => new JsExpression('function (html) { if (/data:image\/[a-z]+;base64,/.test(html)) {console.log("Нельзя вставлять такие картинки")} else { console.log(this); return this.clean.stripTags(html, "<br><a><img><h1><h2><h3><h4><h5><h6><strong><em><del>"); } }'),
        ],
    ]); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
