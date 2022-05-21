<?php

use app\models\Category;
use app\models\User;
use yii\db\Migration;

/**
 * Class m220513_230341_init_app
 */
class m220513_230341_init_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->unique(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'active' => $this->smallInteger()->notNull()->defaultValue(1),
            'is_admin' => $this->smallInteger()->notNull()->defaultValue(0),
            'created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(2000)->notNull(),
            'text' => 'mediumtext not null',
            'url' => $this->string(255)->notNull(),
            'active' => $this->smallInteger()->notNull()->defaultValue(1),
            'created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->null(),
            'sort' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);
        $this->createIndex('parent_sort', '{{%category}}', ['parent_id', 'sort']);
        $this->createIndex('category_name', '{{%category}}', 'name');

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'news_id' => $this->integer()->notNull(),
            'text' => 'mediumtext not null',
            'created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->addForeignKey('news_category_fk', 'news', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('comment_user_fk', 'comment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('comment_news_fk', 'comment', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');

        $user = new User();
        $user->username = 'admin';
        $user->name = 'Админ';
        $user->auth_key = 'DQqeo5HbvWwkjGlxPFv1Ft2PbVnWE262';
        $user->password_hash = '$2y$13$DKGP8Tt2wJNQHncEjubsye0Y8J5/R1zxqTyoIgX4B1jxNSpCPCHQ2';
        $user->password_reset_token = 'njdvTa0WAdLi0WUOyV_9-Bap4dk0un2O_1613401410';
        $user->active = 1;
        $user->is_admin = 1;
        $user->save();

        $sportCategory = new Category();
        $sportCategory->title = 'Спорт';
        $sportCategory->save();

        $ItCategory = new Category();
        $ItCategory->title = 'Айти';
        $ItCategory->save();

        $footballCategory = new Category();
        $footballCategory->parent_id = $sportCategory->id;
        $footballCategory->title = 'Футбол';
        $footballCategory->save();

        $basketballCategory = new Category();
        $basketballCategory->parent_id = $sportCategory->id;
        $basketballCategory->title = 'Баскетбол';
        $basketballCategory->save();

        $tennisCategory = new Category();
        $tennisCategory->parent_id = $sportCategory->id;
        $tennisCategory->title = 'Теннис';
        $tennisCategory->save();

        $frontendCategory = new Category();
        $frontendCategory->parent_id = $ItCategory->id;
        $frontendCategory->title = 'Фронтенд';
        $frontendCategory->save();

        $backendCategory = new Category();
        $backendCategory->parent_id = $ItCategory->id;
        $backendCategory->title = 'Бэкенд';
        $backendCategory->save();

        $newsArray = [
            [
                'category_id' => $footballCategory->id,
                'title' => 'Первая новость про футбол',
                'description' => 'Короткое описание первой новости про футбол вот такое',
                'text' => 'Текст первой новости про футбол',
                'url' => 'pervaya_novost_pro_futbol',
                'active' => 1,
            ],
            [
                'category_id' => $footballCategory->id,
                'title' => 'Вторая новость про футбол',
                'description' => 'Короткое описание второй новости про футбол вот такое',
                'text' => 'Текст второй новости про футбол',
                'url' => 'vtoraya_novost_pro_futbol',
                'active' => 1,
            ],
            [
                'category_id' => $footballCategory->id,
                'title' => 'Третья новость про футбол',
                'description' => 'Короткое описание третьей новости про футбол вот такое',
                'text' => 'Текст третьей новости про футбол',
                'url' => 'tretya_novost_pro_futbol',
                'active' => 1,
            ],
            [
                'category_id' => $basketballCategory->id,
                'title' => 'Первая новость про баскетбол',
                'description' => 'Короткое описание первой новости про баскетбол вот такое',
                'text' => 'Текст первой новости про баскетбол',
                'url' => 'pervaya_novost_pro_basketbol',
                'active' => 1,
            ],
            [
                'category_id' => $basketballCategory->id,
                'title' => 'Вторая новость про баскетбол',
                'description' => 'Короткое описание второй новости про баскетбол вот такое',
                'text' => 'Текст второй новости про баскетбол',
                'url' => 'vtoraya_novost_pro_basketbol',
                'active' => 1,
            ],
            [
                'category_id' => $basketballCategory->id,
                'title' => 'Третья новость про баскетбол',
                'description' => 'Короткое описание третьей новости про баскетбол вот такое',
                'text' => 'Текст третьей новости про баскетбол',
                'url' => 'tretya_novost_pro_basketbol',
                'active' => 1,
            ],
            [
                'category_id' => $tennisCategory->id,
                'title' => 'Первая новость про теннис',
                'description' => 'Короткое описание первой новости про теннис вот такое',
                'text' => 'Текст первой новости про теннис',
                'url' => 'pervaya_novost_pro_tennis',
                'active' => 1,
            ],
            [
                'category_id' => $tennisCategory->id,
                'title' => 'Вторая новость про теннис',
                'description' => 'Короткое описание второй новости про теннис вот такое',
                'text' => 'Текст второй новости про теннис',
                'url' => 'vtoraya_novost_pro_tennis',
                'active' => 1,
            ],
            [
                'category_id' => $tennisCategory->id,
                'title' => 'Третья новость про теннис',
                'description' => 'Короткое описание третьей новости про теннис вот такое',
                'text' => 'Текст третьей новости про теннис',
                'url' => 'tretya_novost_pro_tennis',
                'active' => 1,
            ],
            [
                'category_id' => $tennisCategory->id,
                'title' => 'Четвертая новость про теннис',
                'description' => 'Короткое описание четвертой новости про теннис вот такое',
                'text' => 'Текст четвертой новости про теннис',
                'url' => 'chentvertaya_novost_pro_tennis',
                'active' => 1,
            ],
            [
                'category_id' => $frontendCategory->id,
                'title' => 'Первая новость про фронтенд',
                'description' => 'Короткое описание первой новости про фронтенд вот такое',
                'text' => 'Текст первой новости про фронтенд',
                'url' => 'pervaya_novost_pro_frontend',
                'active' => 1,
            ],
            [
                'category_id' => $frontendCategory->id,
                'title' => 'Вторая новость про фронтенд',
                'description' => 'Короткое описание второй новости про фронтенд вот такое',
                'text' => 'Текст второй новости про фронтенд',
                'url' => 'vtoraya_novost_pro_frontend',
                'active' => 1,
            ],
            [
                'category_id' => $frontendCategory->id,
                'title' => 'Третья новость про фронтенд',
                'description' => 'Короткое описание третьей новости про фронтенд вот такое',
                'text' => 'Текст третьей новости про фронтенд',
                'url' => 'tretya_novost_pro_frontend',
                'active' => 1,
            ],
            [
                'category_id' => $frontendCategory->id,
                'title' => 'Четвертая новость про фронтенд',
                'description' => 'Короткое описание четвертой новости про фронтенд вот такое',
                'text' => 'Текст четвертой новости про фронтенд',
                'url' => 'chentvertaya_novost_pro_frontend',
                'active' => 1,
            ],
            [
                'category_id' => $backendCategory->id,
                'title' => 'Первая новость про бэкенд',
                'description' => 'Короткое описание первой новости про бэкенд вот такое',
                'text' => 'Текст первой новости про бэкенд',
                'url' => 'pervaya_novost_pro_backend',
                'active' => 1,
            ],
            [
                'category_id' => $backendCategory->id,
                'title' => 'Вторая новость про бэкенд',
                'description' => 'Короткое описание второй новости про бэкенд вот такое',
                'text' => 'Текст второй новости про бэкенд',
                'url' => 'vtoraya_novost_pro_backend',
                'active' => 1,
            ],
        ];

        $db = Yii::$app->db;
        $sql = $db->queryBuilder->batchInsert('news',
            ['category_id', 'title', 'description', 'text', 'url', 'active'], $newsArray);
        $db->createCommand($sql)
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220513_230341_init_app cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220513_230341_init_app cannot be reverted.\n";

        return false;
    }
    */
}
