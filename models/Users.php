<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_tb".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $user_type
 * @property string $status
 * @property string|null $profile_pic
 * @property string $password
 * @property string|null  $auth_key
 * @property string $created_on
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'user_type', 'status', 'password'], 'required'],
            [['created_on'], 'safe'],
            ['email','unique'],
            [['username'], 'string', 'max' => 255],
            [['email', 'user_type', 'status', 'profile_pic','auth_key', 'password'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'user_type' => 'User Type',
            'status' => 'Status',
            'profile_pic' => 'Profile Pic',
            'password' => 'Password',
            'created_on' => 'Created On',
        ];
    }

    public function generateRandomString($length)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    public function validatePassword($password){
        return $this->password===md5($password);
    }

    public static function findByEmail($email){
        return self::findOne(['email' => $email,'user_type'=>'admin']);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
    }
    public function getUserAccounts($date){
        return Users::find()->andFilterWhere(['=','year(created_on)',date('Y',strtotime($date))])
            ->andFilterWhere(['=','month(created_on)',date('m',strtotime($date))])->count();
    }
}
