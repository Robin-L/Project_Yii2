<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\UserBackend;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $created_at;
    public $updated_at;

    /**
     * @return array
     * 对数据的校验规则
     */
    public function rules()
    {
        return [
            // 对username的值进行两边空格过滤
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => '用户名不可以为空'],
            // unique表示唯一性，targetClass表示的数据模型
            ['username', 'unique', 'targetClass' => '\backend\models\UserBackend', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => '邮箱不可以为空'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\UserBackend', 'message' => '该邮箱已被使用'],
            ['password', 'required', 'message' => '密码不可以为空'],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码至少填写6位'],
            [['created_at', 'updated_at'], 'default', 'value' => date('Y-m-d H:i:s')],
        ];
    }

    /**
     * @return bool|null
     * 添加成功或者添加失败
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new UserBackend();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->created_at = $this->created_at;
        $user->updated_at = $this->updated_at;

        //TODO:设置密码，密码肯定要加密，暂时还没实现
        $user->setPassword($this->password);
        //生成"remember me" 认证key
        $user->generateAuthKey();
        // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
        return $user->save(false);
    }
}