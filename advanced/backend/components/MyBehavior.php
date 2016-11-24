<?php

namespace backend\components;

use Yii;
use yii\base\ActionFilter;
/**
 * Class MyBehavior
 *
 * @package \backend\components
 */
class MyBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        var_dump(111);
        return true;
    }
}