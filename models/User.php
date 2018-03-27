<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */

    public $password2;

    public static function tableName()
    {
        parent::tableName();
        return 'user';
    }

    public function attributeLabels()
    {
        return [
            'usersurname' => 'Фамилия',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'password2' => 'Подтвердите пароль'
        ];
    }

    public function rules()
    {
        return [
            ['password2', 'compare', 'compareAttribute' => 'password'],
            [['usersurname', 'username', 'email', 'password'], 'required'],
            [['usersurname', 'username', 'email', 'password', 'activation_code', 'auth_key'], 'string', 'max' => 255],
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        return $this->password === $password;
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function checkActivationCode($activation_code)
    {
        if ($activation_code == 'activated') {
            return true;
        }

        return false;
    }

    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
}
