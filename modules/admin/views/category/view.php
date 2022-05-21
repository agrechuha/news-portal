<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

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
        <?= Html::a('Сделать корневой', ['make-root', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Вы уверены, что хотите сделать эту категорию корневой?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'parent_id',
                'value' => $model->parent_id && ($parent = Category::findOne(['id' => $model->parent_id])) ?
                    Html::a($parent->title, Url::toRoute(['category/view', 'id' => $model->parent_id])) : "",
                'format' => 'raw'
            ],
            'sort',
            'name',
            'title',
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
