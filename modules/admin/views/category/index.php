<?php

use app\models\Category;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //            'id',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    if ($model->parent_id) {
                        $parent = Category::findOne(['id' => $model->parent_id]);
                        if ($parent) {
                            return Html::a($parent->title, ['category/view', 'id' => $parent->id]);
                        }
                    }
                    return '';
                },
                'filter' => Select2::widget([
                    'attribute' => 'parent_id',
                    'initValueText' => $searchModel['parent_id'] &&
                    ($parent = Category::findOne(['id' => $searchModel['parent_id']])) ?
                        $parent->title : '',
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
            'sort',
            'name',
            'title',
            //'created',
            //'updated',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
