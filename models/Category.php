<?php

namespace app\models;

use app\helpers\StringHelper;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 * @property string $title
 * @property string $created
 * @property string $updated
 *
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = StringHelper::generateTransliteration($this->title, __CLASS__, 'name');
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
            [['parent_id', 'tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['tree', 'lft', 'rgt', 'depth', 'title'], 'required'],
            [['created', 'updated'], 'safe'],
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
            'tree' => 'Дерево',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Название',
            'title' => 'Заголовок',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
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
