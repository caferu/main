<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
class MyMultiSelect extends CJuiInputWidget
{
    public $data;
    public $filter = false;

    public function run()
    {
        $basePath = dirname(__FILE__) . '/assets/' . get_class($this);
        $baseUrl  = Yii::app()->getAssetManager()->publish($basePath);

        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id'])) $id = $this->htmlOptions['id'];
        else $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name'])) $name = $this->htmlOptions['name'];
        else $this->htmlOptions['name']     = $name;
        $this->htmlOptions['multiple'] = 'multiple';

        if (!preg_match('/\[\]$/', $this->htmlOptions['name'])) {
            $this->htmlOptions['name'] = $this->htmlOptions['name'] . '[]';
        }

        if ($this->hasModel()) {
            echo CHtml::hiddenField(CHtml::resolveName($this->model, $this->attribute), '', array('id' => false));
            echo CHtml::activeListBox($this->model, $this->attribute, $this->data, $this->htmlOptions);
        } else {
            echo CHtml::hiddenField($name, '', array('id' => false));
            echo CHtml::listBox($name, $this->value, $this->htmlOptions);
        }
        $minWidth = 225;
        $checkAllText = 'Выделить все';
        $uncheckAllText = 'Снять выделение';

        if (!empty($this->htmlOptions['minWidth'])) {
            $minWidth = $this->htmlOptions['minWidth'];
        }

        if (!empty($this->htmlOptions['checkAllText'])) {
            $checkAllText = $this->htmlOptions['checkAllText'];
        }

        if (!empty($this->htmlOptions['uncheckAllText'])) {
            $uncheckAllText = $this->htmlOptions['uncheckAllText'];
        }

        $js = "$('#{$id}').multiselect({
            checkAllText: '{$checkAllText}',
            uncheckAllText: '{$uncheckAllText}',
            noneSelectedText: 'Выберите',
            selectedText: '# выбрано',
            minWidth : {$minWidth},
            'header' : false
        });";

        if (!empty($this->htmlOptions['close'])) {
            $js .= " $('#" . $id . "').bind('multiselectclose', " . $this->htmlOptions['close']. '); ';
            //$js .= " $('#" . $id . "').multiselect('close'); ";
        }

        if ($this->filter === true) {
            $js .= "$('#{$id}').multiselectfilter({
                label: 'Фильтр:',
                placeholder: 'Введите слово'
            });";
        }

        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/jquery.multiselect.css');
        $cs->registerScriptFile($baseUrl . '/jquery.multiselect.min.js', CClientScript::POS_END);

        if ($this->filter === true) {
            $cs->registerCssFile($baseUrl . '/jquery.multiselect.filter.css');
            $cs->registerScriptFile($baseUrl . '/jquery.multiselect.filter.min.js', CClientScript::POS_END);
        }

        $cs->registerScript(__CLASS__ . '#' . $this->id, $js);
    }
}
