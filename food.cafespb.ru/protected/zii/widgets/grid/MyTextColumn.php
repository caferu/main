<?php
/**
 * Класс между своими классами типов колонок для грида и yii'шным CDataColumn.
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyTextColumn extends CDataColumn
{
    /**
     * Производится отрисовка содержания ячейки
     *
     * @param array $row  Номер строки
     * @param array $data Данные строки
     */
    protected function renderDataCellContent($row, $data)
    {
        if ($this->value !== null) {
            $params = array(
                'data' => $data,
                'row'  => $row
            );
            $value  = $this->evaluateExpression($this->value, $params);
        } else if ($this->name !== null) {
            $value = CHtml::value($data, $this->name);
        } else {
            $value = $this->grid->dataProvider->keys[$row];
        }

        $options = $this->htmlOptions;
        $name    = $options['name'];
        unset($options['name']);
        $options['value'] = $value;
        $options['id']    = $this->id . '_' . $row;
        if (empty($options['type'])) {
            $options['type'] = 'text';
        }

        $rowId = $data->id;
        if (!empty($_GET[$name][$rowId])) {
            $value = $_GET[$name][$rowId];
        }

        $options['value'] = $value;

        $name            .= '[' . $rowId . ']';
        $options['name'] = $name;

        echo CHtml::tag('input', $options);
    }
}
