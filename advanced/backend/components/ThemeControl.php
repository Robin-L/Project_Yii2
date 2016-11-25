<?php

namespace backend\components;

use Yii;
use yii\base\Object;
use yii\base\ActionFilter;

class ThemeControl extends ActionFilter
{
    public function init()
    {
        $switch = intval(Yii::$app->request->get('switch'));
        $theme = $switch ? 'spring' : 'christmas';

        Yii::$app->view->theme = Yii::createObject([
            'class' => 'yii\base\theme',
            'pathMap' => [
                '@app/views' => [
                    "@app/themes/{$theme}",
                ]
            ],
        ]);
    }
}
