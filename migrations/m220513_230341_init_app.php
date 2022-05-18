<?php

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
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], $tableOptions);

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
