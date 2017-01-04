<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

/**
 * Class TestWidget
 *
 * @package \common\widgets
 */
class TestWidget extends Widget
{
    public function run()
    {
        echo 'This is My test widget.';
    }
}