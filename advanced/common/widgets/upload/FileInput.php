<?php

namespace common\widgets\upload;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\widgets\InputWidget;

/**
 * Class FileInput
 *
 * @package \common\widgets\upload
 */
class FileInput extends InputWidget
{

    public function run()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();
        // 构建html结构
        if ($this->hasModel()) {
            $this->options = array_merge($this->options, $this->clientOptions);
            $file = Html::activeInput('file', $this->model, $this->attribute, $this->options);
            // 如果当前模型有该属性值，则默认显示
            if ($image = $this->model->{str_replace(['[', ']'], '', $this->attribute)}) {
                $li = Html::tag('li', '', ['class' => 'uploader__file', 'style' => 'background: url('.Yii::$app->params['imageServer']. $image .') no-repeat; background-size: 100%;']);
            }
            $uploaderFiles = Html::tag('ul', isset($li) ? $li : '', ['class' => 'uploaderFiles']);
            $inputButton = Html::tag('div', $file, ['class' => 'input-box']);
            echo Html::tag('div', $uploaderFiles.$inputButton, ['class' => 'file-div']);
        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        FileInputAsset::register($view);
    }

}