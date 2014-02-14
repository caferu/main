<?php

Yii::import('zii.widgets.jui.CJuiInputWidget');

class MyJuiDateTimePicker extends CJuiInputWidget {
    public $extraScriptFile = "jquery-ui-timepicker-addon.min.js";
    public $extraCssFile = "jquery-ui-timepicker-addon.css";
    public $timePickerOnly = false;

    public function run() {
        $basePath = dirname(__FILE__) . '/assets/' . get_class($this);
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath);
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/' . $this->extraCssFile);
        $cs->registerScriptFile($baseUrl . '/' . $this->extraScriptFile, CClientScript::POS_END);
        
        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];
        else
            $this->htmlOptions['name'] = $name;

        if ($this->hasModel())
            echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textField($name, $this->value, $this->htmlOptions);

        $options = CJavaScript::encode(CMap::mergeArray(array(
            'timeOnlyTitle' => 'Выберите время',
            'timeText' => 'Время',
            'hourText' => 'Часы',
            'minuteText' => 'Минуты',
            'secondText' => 'Секунды',
            'currentText' => 'Сейчас',
            'closeText' => 'Закрыть',
        ), $this->options));

        if ($this->timePickerOnly)
            $js = "jQuery('#{$id}').timepicker($options);";
        else
            $js = "jQuery('#{$id}').datetimepicker($options);";

        $cs->registerScript(__CLASS__ . '#' . $id, $js);
    }
}
