<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use common\entities\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\entities\User', 'message' => 'Этот E-mail уже занят другим пользователем.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Имя'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }

    public function signup(): User
    {
        if (!$this->validate()) {
            return null;
        }
        return User::signup($this->username, $this->email, $this->password);
    }
}
