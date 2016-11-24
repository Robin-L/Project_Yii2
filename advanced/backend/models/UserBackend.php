<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_backend".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class UserBackend extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_backend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	/**
	 * @param int|string $id
	 * @return static
	 * 根据user_backend表的主键(id)获取用户
	 */
    public static function findIdentity($id)
	{
		return static::findOne(['id' => $id]);
	}
	
	/**
	 * @param mixed $token
	 * @param null  $type
	 * @return void|IdentityInterface
	 * @throws NotSupportedException
	 * 根据access_token获取用户，暂时先不实现
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		// TODO: 暂不实现可参考:http://www.manks.top/yii2-restful-api.html
		throw new NotSupportedException('"finIdentityByAccessToken" is not implemented.');
	}
	
	/**
	 * @return mixed
	 * 用以标识Yii::$app->user->id的返回值
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}
	
	/**
	 * @return string
	 * 获取auth_key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

    /**
     * @param string $authKey
     * 验证auth_key
     * @return bool|void
     */
	public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $password
     * 为model的password_hash字段生成密码的hash值
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 生成"remember me"认证KEY
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param $username
     * @return static
     * 根据user_backend表的username获取用户
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @param $password
     * @return bool
     * 验证密码的准确性
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}
