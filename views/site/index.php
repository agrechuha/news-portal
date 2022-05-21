<?php

/** @var yii\web\View $this */
/** @var \app\models\Category $selectedCategory */
/** @var \app\models\News[] $news */
/** @var \yii\data\Pagination $pagination */

/** @var string $dateSort */

use app\assets\IndexAsset;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Новостной портал';

if ($dateSort) {
    $this->registerJs('window.dateSort = "' . $dateSort . '";', View::POS_HEAD);
}

IndexAsset::register($this);
?>
<div class="site-index">

    <div id="news">
        <div id="news-container" class="container">
            <label id="date-sort-block">
                Сортировать новости по дате
                <select name="date" id="date-sort">
                    <option value="DESC">По возрастанию (сначала новые)</option>
                    <option value="ASC" <?= $dateSort === 'ASC' ? 'selected' : '' ?>>По возрастанию (сначала старые)
                    </option>
                </select>
            </label>

            <?php Pjax::begin(['id' => 'news-pjax']); ?>
            <?php if ($selectedCategory) : ?>
                <div class="category-name">Выбранная категория: <?= $selectedCategory->title?></div>
            <?php endif;?>
            <?php if ($news) : ?>
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
            <?php else : ?>
                Новостей в выбранной категории нет
            <?php endif; ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
