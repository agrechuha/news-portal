<?php
namespace app\assets;

class CurrentNewsAsset extends BaseAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/current-news.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
