<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $status
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $logged_in_ip
 * @property string $logged_in_at
 * @property string $created_ip
 * @property string $created_at
 * @property string $updated_at
 * @property string $banned_at
 * @property string $banned_reason
 * @property integer $departamento_id
 * @property string $responsable_departamento
 * @property string $marketing
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
            [['role_id', 'status'], 'required'],
            [['role_id', 'status', 'departamento_id'], 'integer'],
            [['logged_in_at', 'created_at', 'updated_at', 'banned_at'], 'safe'],
            [['email', 'username', 'password', 'auth_key', 'access_token', 'logged_in_ip', 'created_ip', 'banned_reason'], 'string', 'max' => 255],
            [['responsable_departamento'], 'string', 'max' => 10],
            [['marketing'], 'string', 'max' => 5],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'logged_in_ip' => 'Logged In Ip',
            'logged_in_at' => 'Logged In At',
            'created_ip' => 'Created Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'banned_at' => 'Banned At',
            'banned_reason' => 'Banned Reason',
            'departamento_id' => 'Departamento ID',
            'responsable_departamento' => 'Responsable Departamento',
            'marketing' => 'Marketing',
        ];
    }
}
