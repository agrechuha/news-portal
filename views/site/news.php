<?php

/** @var yii\web\View $this */
/** @var News $news */
/** @var Comment[] $comments */
/** @var \yii\data\Pagination $commentsPagination */

use app\models\Comment;
use app\models\News;
use vova07\imperavi\Widget;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = $news->title;

\app\assets\CurrentNewsAsset::register($this);
?>
<div class="site-index">
    <div id="news">
        <h1><?= $news->title ?></h1>
        <div class="news-text">
            <?= $news->text ?>
        </div>
    </div>

        <div id="comments">
            <h3>Комментарии к новости</h3>
            <?php if ($comments) : ?>
            <?php Pjax::begin(['id' => 'comments-pjax']); ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="comment">
                    <div class="comment-header">
                        <div class="author"><?= $comment->user->getFullName() ?></div>
                        <div class="date"><?= Yii::$app->formatter->asDatetime($comment->created,
                                'dd MMMM y, HH:mm') ?></div>
                    </div>
                    <div class="text"><?= $comment->text ?></div>
                </div>
            <?php endforeach; ?>
            <?= LinkPager::widget([
                'pagination' => $commentsPagination,
                'registerLinkTags' => true
            ]); ?>
            <?php Pjax::end(); ?>
            <?php else : ?>
                <div>У новости пока нет комментариев. Будьте первым, кто напишет комментарий</div>
            <?php endif; ?>

        </div>

    <?php if (Yii::$app->user->identity) : ?>
        <?php $form = ActiveForm::begin(['id' => 'comment-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
            'method' => 'post'
        ]); ?>
        <?= $form->field(new Comment(), 'text')->widget(Widget::className(), [
            'options' => [
                'id' => 'comment',
                'label' => null,
            ],
            'settings' => [
                'placeholder' => 'Начните писать комментарий для новости',
                'lang' => 'ru',
                'minHeight' => 53,
                'replaceDivs' => false,
                'linebreaks' => true,
                'imageEditable' => false,
                'linkTarget' => '_blank',
                'plugins' => [
                    'counter',
                    'definedlinks',
                    'limiter',
                ],
                'buttons' => [
                    'bold',
                    'italic',
                    'unorderedlist',
                    'orderedlist',
                ],
                'syncCallback' => new JsExpression('function(html) {
                                                let comment = $("#comment");
                                                if (this.utils.isEmpty(html)) {
                                                    comment.val("");
                                                    comment.trigger("change");
                                                } else {
                                                    comment.trigger("change");
                                                }
                                            }'),
                'pasteCallback' => new JsExpression('function(html) {
                                                if (html.indexOf("<img") !== -1) {
                                                    return ""
                                                } else {
                                                    return html
                                                }
                                            }'),
                'insertedLinkCallback' => new JsExpression('function(link) {
                                                    $("#comment").trigger("change");
                                                }'),
            ],
        ]); ?>
        <button type="submit" class="btn btn-primary submit-btn disabled">
            Отправить
        </button>
        <?php ActiveForm::end(); ?>
    <?php endif;?>

</div>
