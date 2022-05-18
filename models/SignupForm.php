<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;

    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'validateName'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Данный username уже занят'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Данный e-mail уже занят'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен быть не меньше 6-ти символов'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'name' => 'Имя',
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

    public function validateName($attribute, $params) {
        if (!$this->hasErrors()) {
            $name = preg_replace('|\s+|', ' ', trim($this->name));
            $nameArray = explode(' ', $name);
            if ($nameArray && (count($nameArray) > 1)) {
                $this->addError($attribute, 'Введите только свое имя');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = Yii::$app->userComponent->signup($this->username, $this->name, $this->email, $this->password);

        return Yii::$app->user->login($user, 3600*24*30);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
