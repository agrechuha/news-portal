<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">

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
            [
                'attribute' => 'user_id',
                'value' => ($model->user_id) ?
                    Html::a($model->user->getFullName(), Url::toRoute(['user/view', 'id' => $model->user_id])) : "",
                'format' => 'raw'
            ],
            [
                'attribute' => 'news_id',
                'value' => ($model->news_id) ?
                    Html::a($model->news->title, Url::toRoute(['news/view', 'id' => $model->news_id])) : "",
                'format' => 'raw'
            ],
            'text:raw',
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
