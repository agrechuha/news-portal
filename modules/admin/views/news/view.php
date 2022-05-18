<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-view">

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
                'attribute' => 'category_id',
                'value' => ($model->category_id) ?
                    Html::a($model->category->name, Url::toRoute(['category/view', 'id' => $model->category_id])) : "",
                'format' => 'raw'
            ],
            'title',
            'description',
            'text:raw',
            'url',
            'active:boolean',
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
