<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'email:email',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'active:boolean',
            'is_admin:boolean',
            [
                'attribute' => 'created',
                'value' => Yii::$app->formatter->asDatetime($model->created, 'dd MMMM HH:mm'),
                'format' => 'raw'
            ],
            [
                'attribute' => 'updated',
                'value' => Yii::$app->formatter->asDatetime($model->updated, 'dd MMMM HH:mm'),
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
