<?php

class EColorBox extends CWidget
{
    public $id;
    public $target;
    public $config = array();

    public function init()
    {
        if (!isset($this->id))
            $this->id = $this->getId();
        $this->publishAssets();
    }

    public function run()
    {
        $config = CJavaScript::encode($this->config);
        Yii::app()->clientScript->registerScript($this->getId(), "jQuery('$this->target').colorbox($config);");
    }

    public function publishAssets()
    {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.colorbox-min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/colorbox.css');
        } else {
            throw new CException('EColorBox error: couldn\'t find assets to publish.');
        }
    }
}
