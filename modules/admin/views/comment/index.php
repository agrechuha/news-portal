<?php

use app\models\Comment;
use app\models\News;
use app\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать комментарий', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'label' => 'Пользователь',
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user ?
                        Html::a($model->user->getFullName(), ['user/view', 'id' => $model->user->id]) : '';
                },
                'filter' => Select2::widget([
                    'attribute' => 'user_id',
                    'initValueText' => $searchModel['user_id'] ?
                        User::findOne(['id' => $searchModel['user_id']])->getFullName() : '',
                    // set the initial display text
                    'model' => $searchModel,
                    'options' => ['placeholder' => 'Поиск...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Поиск...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['user/search-ajax']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(obj) { return obj.text; }'),
                        'templateSelection' => new JsExpression('function (obj) { return obj.text; }'),
                    ],
                ]),
                'format' => 'html',
            ],
            [
                'label' => 'Новость',
                'attribute' => 'news_id',
                'value' => function ($model) {
                    return $model->news ?
                        Html::a($model->news->title, ['news/view', 'id' => $model->news_id]) : '';
                },
                'filter' => Select2::widget([
                    'attribute' => 'news_id',
                    'initValueText' => $searchModel['news_id'] ?
                        News::findOne(['id' => $searchModel['news_id']])->title : '',
                    // set the initial display text
                    'model' => $searchModel,
                    'options' => ['placeholder' => 'Поиск...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Поиск...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['news/search-ajax']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(obj) { return obj.text; }'),
                        'templateSelection' => new JsExpression('function (obj) { return obj.text; }'),
                    ],
                ]),
                'format' => 'html',
            ],
            'text:ntext',
//            'created',
            //'updated',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Comment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
