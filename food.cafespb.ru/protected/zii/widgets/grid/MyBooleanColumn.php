<?php
Yii::import('application.zii.widgets.grid.MyDataColumn');
/**
 * Класс булевой колонки для грида.
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyBooleanColumn extends MyDataColumn
{
    /**
     * Аттрибут модели.
     *
     * @var string
     */
    public $name;

    /**
     * Значение.
     *
     * @var string
     */
    public $value;

    /**
     * Отрисовка значения ячейки.
     *
     * @param integer $row  номер строки (с нуля)
     * @param mixed   $data массив данных
     */
    protected function renderDataCellContent($row, $data)
    {
        if (!isset($this->value)) {
            $value = $data->{$this->name};
        } else {
            $value = $this->evaluateExpression($this->value, array('data' => $data));
        }

        echo parent::booleanColumn($value);
    }
}
