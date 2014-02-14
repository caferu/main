<?php
class MyButtonLabelColumn extends MyDataColumn
{
    public $labelClass;

    public function init()
    {
        $this->type  = 'html';
        $this->width = 1;

        parent::init();
    }

    public function renderDataCellContent($row, $data)
    {
        $primaryKey = $data->getPrimaryKey();
        $link       = MyHtml::link($this->value, '#', array('data-pk' => $primaryKey));

        $spanClass = 'label_' . $primaryKey . ' label ' . $this->labelClass;

        echo '<span class="' . $spanClass . '">' . $link . '</span>';
    }
}
