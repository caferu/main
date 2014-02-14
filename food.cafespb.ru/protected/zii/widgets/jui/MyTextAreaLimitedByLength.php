<?php
/**
 * Created by IntelliJ IDEA.
 * User: execut
 * Date: 30.09.11
 * Time: 13:34
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');
class MyTextAreaLimitedByLength extends CJuiInputWidget
{
    public $data;
    public $maxLength = 100;
    public function run()
    {
        parent::run();
        list($name, $id) = $this->resolveNameID();

        $basePath = dirname(__FILE__) . '/assets/' . get_class($this);

        $app     = Yii::app();
        $baseUrl = $app->getAssetManager()->publish($basePath);
        $cs      = $app->getClientScript();
        $cs->registerCssFile($baseUrl . '/myTextAreaLimitedByLength.css');
        $cs->registerScriptFile($baseUrl . '/myTextAreaLimitedByLength.js', CClientScript::POS_END);

        $maxLength = (int)$this->maxLength;
        $js        = "$('#{$id}').textAreaLimitedByLength({
            maxLength: $maxLength
        });";
        $cs->registerScript(__CLASS__ . '#' . $this->id, $js);

        $this->htmlOptions['class'] = get_class($this);
        echo CHtml::textArea($name, $this->value, $this->htmlOptions);
    }
}
