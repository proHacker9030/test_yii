<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $usersurname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $activation_code
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usersurname', 'username', 'email', 'password', 'activation_code'], 'required'],
            [['usersurname', 'username', 'email', 'password', 'activation_code', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usersurname' => 'Фамилия',
            'username' => 'Имя',
            'email' => 'E-mail',
            'password' => 'Password',
            'activation_code' => 'Activation Code',
            'auth_key' => 'Auth Key',
        ];
    }
}
