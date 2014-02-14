<?php

class EFancyBox extends CWidget
{
    public $id;
    public $target;
    public $easingEnabled = false;
    public $mouseEnabled = true;
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
        Yii::app()->clientScript->registerScript($this->getId(), "jQuery('$this->target').fancybox($config);");
    }

    public function publishAssets()
    {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.fancybox-1.3.4.pack.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/jquery.fancybox-1.3.4.css');
            if ($this->mouseEnabled) {
                Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD);
            }
            if ($this->easingEnabled) {
                Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.easing-1.3.pack.js', CClientScript::POS_HEAD);
            }
        } else {
            throw new CException('EFancyBox error: couldn\'t find assets to publish.');
        }
    }
}
