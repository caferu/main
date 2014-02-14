<?php
class MyEnumerableColumn extends CDataColumn
{
    public $name;

    protected function renderDataCellContent($row, $data)
    {
        $attributeEnums = $data->getAttributeEnums($this->name);
        if (isset($attributeEnums[$data->{$this->name}])) {
            echo $attributeEnums[$data->{$this->name}];
        }
    }
}
