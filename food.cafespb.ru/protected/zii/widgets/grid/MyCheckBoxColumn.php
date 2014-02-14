<?php
class MyCheckBoxColumn extends CCheckBoxColumn
{
    public $actions;
    public $hidden;

    protected function renderDataCellContent($row, $data)
    {
        if ($this->hidden !== null) $hidden = $this->evaluateExpression($this->hidden, array(
            'data' => $data,
            'row'  => $row
        ));
        if ($this->value !== null) $value = $this->evaluateExpression($this->value, array(
            'data' => $data,
            'row'  => $row
        ));
        else if ($this->name !== null) $value = CHtml::value($data, $this->name);
        else $value = $this->grid->dataProvider->keys[$row];

        $checked = false;
        if ($this->checked !== null) $checked = $this->evaluateExpression($this->checked, array(
            'data' => $data,
            'row'  => $row
        ));

        $options = $this->checkBoxHtmlOptions;
        $name    = $options['name'];
        unset($options['name']);
        $options['value'] = $value;
        // $style = ($hidden)?"display:none":'';
        $style            = ($hidden) ? 'display:none' : '';
        $options['style'] = $style;
        $options['id']    = $this->id . '_' . $row;
        echo CHtml::checkBox($name, $checked, $options);
    }

    /**
     * Renders the header cell content.
     * This method will render a checkbox in the header when {@link selectableRows} is greater than 1
     * or in case {@link selectableRows} is null when {@link CGridView::selectableRows} is greater than 1.
     */
    protected function renderHeaderCellContent()
    {
        if (!empty($this->header)) echo $this->header;
        else if ($this->selectableRows === null && $this->grid->selectableRows > 1) echo CHtml::checkBox($this->id . '_all', false, array('class' => 'select-on-check-all'));
        else if ($this->selectableRows > 1) echo CHtml::checkBox($this->id . '_all', false);
        else parent::renderHeaderCellContent();
    }
}
