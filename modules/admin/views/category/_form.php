<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $text = '';
    if ($model->parent_id && ($parent = Category::findOne(['id' => $model->parent_id]))) {
        $text = $parent->title;
    }
    echo $form->field($model, 'parent_id')->widget(kartik\select2\Select2::classname(), [
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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
