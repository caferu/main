<?php
Yii::import('application.zii.widgets.grid.MyDataColumn');
/**
 * Класс динамического типа колонки.
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyGridHistoriableDataColumn extends MyDataColumn
{
    /**
     * Отрисовка значения ячейки.
     *
     * @param integer $row  номер строки (с нуля)
     * @param mixed   $data массив данных
     */
    protected function renderDataCellContent($row, $data)
    {
        if ($this->value !== null) {
            $valueData = array(
                'data' => $data,
                'row'  => $row
            );
            $value     = $this->evaluateExpression($this->value, $valueData);
        } else {
            $value = CHtml::value($data, $this->name);

            $model = new $data->model;
            if (array_key_exists($data->attribute, $model->getMetaData()->columns)) {
                switch ($model->getMetaData()->columns[$data->attribute]->type) {
                    case 'boolean':
                        $value = MyDataColumn::booleanColumn($value == 1);
                    break;
                }
            } else if (array_key_exists($data->attribute, $model->getMetaData()->relations)) {
                if ($model->getMetaData()->relations[$data->attribute] instanceof CManyManyRelation) {
                    $modelValues = CJSON::decode($value);
                    foreach ($modelValues as $modelValue) {
                        $modelValuesHtml[] = ObjectStreetRetailDealType::model()->findByPk($modelValue);
                    }

                    $value = implode('<br />', $modelValuesHtml);
                }
            }
        }

        echo $value;
    }
}
