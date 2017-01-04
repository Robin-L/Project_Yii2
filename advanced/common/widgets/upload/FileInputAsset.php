<?php

namespace common\widgets\upload;
use yii\web\AssetBundle;

/**
 * Class FileInputAsset
 *
 * @package \common\widgets\upload
 */
class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/upload';
    public $css = [
        'css/fileinput.css'
    ];
    public $js = [
        'js/fileinput.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}