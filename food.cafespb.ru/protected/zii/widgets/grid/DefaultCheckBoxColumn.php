<?php

class DefaultCheckboxColumn extends CCheckBoxColumn {

    public function init() {
        $name = isset($this->checkBoxHtmlOptions['name']) ? $this->checkBoxHtmlOptions['name'] : $this->id;
        if (substr($name, -2) !== '[]')
            $name.='[]';
        $this->checkBoxHtmlOptions['name'] = $name;
        $name = strtr($name, array('[' => "\\[", ']' => "\\]"));
        if ($this->grid->selectableRows == 1)
            $one = "\n\tjQuery(\"input:not(#\"+$(this).attr('id')+\")[name='$name']\").attr('checked',false);";
        else
            $one='';
    }

    protected function renderHeaderCellContent() {
        parent::renderHeaderCellContent();
    }

}