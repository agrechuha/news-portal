<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord) : ?>
        <label class="control-label" for="admin-info">Пароль</label>
        <div class="input-group" style="margin-bottom: 30px;">
            <?= $form->field($model, 'password', ['template' => '{input}', 'options' => [
                'tag' => false, // Don't wrap with "form-group" div
            ],])->textInput(['maxlength' => true,
                'id' => 'pass',
                'class' => 'form-control']) ?>
            <div class="input-group-btn">
                <button class="btn btn-primary"
                        onclick="$('#pass').val(Math.random().toString(36).slice(-8))" type="button">Сгенерировать
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'is_admin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
