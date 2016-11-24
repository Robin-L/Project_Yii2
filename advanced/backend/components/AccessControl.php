<?php

namespace backend\components;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\base\ActionFilter;

/**
 * Class AccessControl
 *
 * @package \backend\components
 */
class AccessControl extends ActionFilter
{
    public function beforeAction($action)
    {
        // 当前路由
        $actionId = $action->getUniqueId();
        $actionId = '/' . $actionId;

        // 当前登录用户的id
        $user = Yii::$app->getUser();
        $userId = $user->id;

        // 获取当前用户已经分配过的路由权限
        // 写的比较简单，有过基础的可自行完善，比如解决"*"的问题，看不懂的该行注释自行忽略
        $routes = [];
        $manager = Yii::$app->getAuthManager();
        foreach ($manager->getPermissionsByUser($userId) as $name => $value) {
            if ($name[0] === '/') {
                $routes[] = $name;
            }
        }
        // 判断当前用户是否有权限访问正在请求的路由
        if (in_array($actionId, $routes)) {
            return true;
        }
        $this->denyAccess($user);
    }

    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException('不允许访问.');
        }
    }
}