<?php

Yii::import('zii.widgets.grid.CDataColumn');

class MySumColumn Extends CDataColumn
{
    public $sum = 0;
    public $name;
    public $value;
    public $print;

    public function getHasFooter()
    {
        return true;
    }

    public function renderDataCellContent($row, $data)
    {
        if (isset($this->name)) {
            $amount = $data->{$this->name};
        } else {
            $amount = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
        }

        if (isset($this->print)) {
            echo $this->evaluateExpression($this->print, array('value' => $amount));
        } else {
            echo $amount;
        }

        $this->sum += (float)$amount;
    }

    public function renderFooterCellContent()
    {
        if (isset($this->print)) {
            echo $this->evaluateExpression($this->print, array('value' => $this->sum));
        } else {
            echo $this->sum;
        }
    }
}
