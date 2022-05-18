<?php

use app\models\Category;
use app\models\News;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category_id ?
                        Html::a($model->category->name, ['category/view', 'id' => $model->category_id]) : '';
                },
                'filter' => Select2::widget([
                    'attribute' => 'category_id',
                    'initValueText' => $searchModel['category_id'] ?
                        Category::findOne(['id' => $searchModel['category_id']])->name : '',
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
                            'url' => Url::to(['category/search-ajax']),
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
            'title',
            'description',
//            'text:ntext',
            'active:boolean',
            //'created',
            //'updated',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, News $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
