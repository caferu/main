<?php
Yii::import('application.zii.widgets.grid.MyDataColumn');
/**
 * Класс колонки со значениями типа Dаte с фильтром для выбора периода
 *
 * @package    System
 * @subpackage Grid
 * @author     Ivan Petrunya <petrunja@becar.ru>
 */
class MyDateColumn extends MyDataColumn
{
    /**
     * Renders the filter cell content.
     * This method will render the {@link filter} as is if it is a string.
     * If {@link filter} is an array, it is assumed to be a list of options, and a dropdown selector will be rendered.
     * Otherwise if {@link filter} is not false, a text field is rendered.
     * @since 1.1.1
     */
    protected function renderFilterCellContent()
    {
        $widget = new CWidget();

        $html = $widget->widget('application.zii.widgets.jui.MyJuiDatePicker', array(
            'model'       => $this->grid->filter,
            'attribute'   => $this->name . '_from',
            'htmlOptions' => array('style' => 'width:60px')
        ), true);
        $html .= ' - ';
        $html .= $widget->widget('application.zii.widgets.jui.MyJuiDatePicker', array(
            'model'       => $this->grid->filter,
            'attribute'   => $this->name . '_to',
            'htmlOptions' => array('style' => 'width:60px')
        ), true);

        echo $html;
    }
}
