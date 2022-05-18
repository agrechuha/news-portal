<?php

namespace app\models;

use app\helpers\StringHelper;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $url
 * @property int $active
 * @property string $created
 * @property string $updated
 *
 * @property Category $category
 * @property Comment[] $comments
 */
class News extends \yii\db\ActiveRecord
{
    const PAGE_SIZE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->url = StringHelper::generateTransliteration($this->title, __CLASS__, 'url');
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'text'], 'required'],
            [['category_id', 'active'], 'integer'],
            [['text'], 'string'],
            [['created', 'updated'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'description' => 'Короткое описание',
            'text' => 'Текст',
            'url' => 'URL',
            'active' => 'Активная',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['news_id' => 'id']);
    }
}
