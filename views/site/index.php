<?php

/** @var yii\web\View $this */
/** @var \app\models\Category $selectedCategory */
/** @var \app\models\Category[] $categories */
/** @var \app\models\News[] $news */
/** @var \yii\data\Pagination $pagination */
/** @var string $dateSort */

use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Новостной портал';

if ($dateSort) {
    $this->registerJs('window.dateSort = "' . $dateSort . '";',View::POS_HEAD);
}
?>
<div class="site-index">

    <div id="news">
        <div id="news-container" class="container">
            <div id="news-title">Выберите категорию новости</div>
            <div class="buttons-kinds">
                <button class="btn btn-primary <?= !$selectedCategory ? 'active' : '' ?>" data-category="">Все</button>
                <?php foreach ($categories as $category) : ?>
                    <button class="btn btn-primary <?= ($selectedCategory && ($selectedCategory->name === $category->name) ? 'active' :
                        '') ?>" data-category="<?= $category->name ?>"><?= $category->title ?></button>
                <?php endforeach; ?>
            </div>
            <label id="date-sort-block">
                Сортировать новости по дате
                <select name="date" id="date-sort">
                    <option value="DESC">По возрастанию (сначала новые)</option>
                    <option value="ASC" <?= $dateSort === 'ASC' ? 'selected' : ''?>>По возрастанию (сначала старые)</option>
                </select>
            </label>

            <?php Pjax::begin(['id' => 'news-pjax']); ?>

            <div id="news-items">
                <?php foreach ($news as $currentNews) : ?>
                    <?= $this->render('partials/_news', [
                        'news' => $currentNews
                    ]) ?>
                <?php endforeach; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'registerLinkTags' => true
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
