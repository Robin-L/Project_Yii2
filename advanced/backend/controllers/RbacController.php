<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        //添加 "/blog/index" 权限
        $blogIndex = $auth->createPermission('/blog/index');
        $blogIndex->description = '博客列表';
        $auth->add($blogIndex);

        // 创建一个角色blogManager, 并为该角色分配"/blog/index"权限
        $blogManager = $auth->createRole('博客管理');
        $auth->add($blogManager);
        $auth->addChild($blogManager, $blogIndex);
        $auth->addChild($blogManager, $blogIndex);
        // 为用户 admin (该用户的uid=1) 分配角色"博客管理"权限
        $auth->assign($blogManager, 1);
    }

    public function actionInit2()
    {
        $auth = Yii::$app->authManager;
        $blogView = $auth->createPermission('/blog/view');
        $auth->add($blogView);
        $blogCreate = $auth->createPermission('/blog/create');
        $auth->add($blogCreate);
        $blogUpdate = $auth->createPermission('/blog/update');
        $auth->add($blogUpdate);
        $blogDelete = $auth->createPermission('/blog/delete');
        $auth->add($blogDelete);

        // 创建一个角色blogManager, 并为该角色分配"/blog/index"权限
        $blogManager = $auth->createRole('博客管理');
        $auth->addChild($blogManager, $blogView);
        $auth->addChild($blogManager, $blogCreate);
        $auth->addChild($blogManager, $blogUpdate);
        $auth->addChild($blogManager, $blogDelete);
    }
}