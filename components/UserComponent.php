<?php

namespace app\components;

use app\helpers\FormHelper;
use app\models\User;
use Yii;
use yii\base\Component;
use yii\helpers\Html;

/**
 * Class UserComponent
 * @package app\components
 */
class UserComponent extends Component
{
    /**
     * Creating user
     * @param $username
     * @param $name
     * @param $email
     * @param $password
     * @return User
     * @throws \yii\base\Exception
     */
    public function signup($username, $name, $email, $password): User
    {
        $user = new User();
        $user->email = $email;
        $user->username = $username;
        $user->name = $name;
        $user->active = 1;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        $result = $user->save();
        if (!$result) {
            throw new \Error(FormHelper::getAllErrors($user->getErrors()));
        }

        return $user;
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function generatePassword($length = 8)
    {
        $password = '';
        $arr = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        for ($i = 0; $i < $length; $i++) {
            $password .= $arr[random_int(0, count($arr) - 1)];
        }
        return $password;
    }
}