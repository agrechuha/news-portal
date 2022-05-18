<?php
/* @var $news News */

use app\models\News;
use yii\helpers\Url;

?>
<div class="news-item">
    <div class="news-detail">
        <div class="news-content">
            <div class="news-title">
                <?= $news->title ?>
            </div>
            <div class="news-description">
                <?= $news->description?>
            </div>
        </div>
        <a href="<?= Url::toRoute(['site/news', 'url' => $news->url]) ?>"
           class="btn btn-primary">
            <svg width="20" height="12" viewBox="0 0 20 12" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M13.1531 1.05411C12.8974 0.833525 12.4948 0.833525 12.2391 1.05411C11.992 1.26725 11.992 1.62197 12.2391 1.83461L16.8738 5.83249H1.57988C1.22336 5.83249 0.930779 6.07692 0.930779 6.38445C0.930779 6.69198 1.22336 6.94436 1.57988 6.94436H16.8738L12.2391 10.9348C11.992 11.1554 11.992 11.5106 12.2391 11.7232C12.4948 11.9438 12.8974 11.9438 13.1531 11.7232L18.885 6.77892C19.1321 6.56579 19.1321 6.21106 18.885 5.99842L13.1531 1.05411Z"
                      fill="white"/>
            </svg>
        </a>
        <div class="date"><?= Yii::$app->formatter->asDatetime($news->created,
                'dd MMMM y, HH:mm') ?></div>
        <div class="category">Категория: <?= $news->category->title ?></div>
    </div>
</div>
