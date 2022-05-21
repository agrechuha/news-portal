<?php

namespace app\models;

use app\helpers\StringHelper;
use paulzi\adjacencyList\AdjacencyListBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property string $created
 * @property string $updated
 *
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => AdjacencyListBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort'], 'integer'],
            [['title'], 'required'],
            [['created', 'updated'], 'safe'],
            [['sort'], 'number'],
            [['name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'title' => 'Заголовок',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord || !$this->name) {
            $this->name = StringHelper::generateTransliteration($this->title, __CLASS__, 'name');
        }
        if (empty($this->parent_id)) {
            $this->makeRoot();
        } else if ($parent = Category::findOne(['id' => $this->parent_id])) {
            $this->prependTo($parent);
        }
        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function getRootList() {
        return self::find()->roots()->with('children')->all();
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }
}
