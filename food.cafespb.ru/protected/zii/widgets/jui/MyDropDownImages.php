<?php
/**
 * Created by IntelliJ IDEA.
 * User: execut
 * Date: 30.09.11
 * Time: 13:34
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');
class MyDropDownImages extends CJuiInputWidget
{
    public $data;
    public $options = array('isShowEmptyOption' => true);
    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        if (!empty($this->value)) {
            $value = $this->value;
        } else {
            $value = '\'\'';
        }

        if ($this->hasModel()) {
            $name = CHtml::resolveName($this->model, $this->attribute);
        }

        echo CHtml::hiddenField($name, $value, array('id' => $id));

        $app = Yii::app();
        $this->registerScripts();
        $cs = $app->getClientScript();

        ksort($this->data);

        $label = empty($this->options['label']) ? 'false' : $this->options['label'];

        $dataJSON          = CJSON::encode($this->data);
        $isShowEmptyOption = $this->options['isShowEmptyOption'] ? 'true' : 'false';
        $js                = "$('#{$id}').dropDownImages({
            data: $dataJSON,
            isShowEmptyOption: $isShowEmptyOption,
            value: $value,
            label: $label
        });";
        $cs->registerScript(__CLASS__ . '#' . $this->id, $js);
    }

    public static function registerScripts()
    {
        $basePath = dirname(__FILE__) . '/assets/MyDropDownImages';
        $app      = Yii::app();
        $baseUrl  = $app->getAssetManager()->publish($basePath);
        $cs       = $app->getClientScript();
        $cs->registerCssFile($baseUrl . '/myDropDownImages.css');
        $cs->registerScriptFile($baseUrl . '/myDropDownImages.js', CClientScript::POS_END);
    }
}
