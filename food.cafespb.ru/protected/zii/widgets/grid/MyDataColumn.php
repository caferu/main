<?php
/**
 * Класс между своими классами типов колонок для грида и yii'шным CDataColumn.
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyDataColumn extends CDataColumn
{
    public $wrap = true;
    public $width;

    /**
     * Возвращает икноку да/нет в зависимости от переданного значения.
     *
     * @param boolean $value да/нет
     *
     * @static
     * @return string
     */
    public static function booleanColumn($value)
    {
        if (empty($value)) {
            $img = 'cross.png';
        } else {
            $img = 'tick.png';
        }

        return CHtml::image(Yii::app()->request->baseUrl . '/images/fugue/' . $img);
    }

    public function renderDataCell($row)
    {
        if ($this->wrap === false) {
            $this->htmlOptions['style'] = 'white-space: nowrap;';
        }

        if ($this->grid->hideHeader == true) {
            if (isset($this->width)) {
                $this->htmlOptions['width'] = $this->width;
            }
        }

        parent::renderDataCell($row);
    }

    public function renderHeaderCell()
    {
        if (isset($this->width)) {
            $this->headerHtmlOptions['width'] = $this->width;
        }

        parent::renderHeaderCell();
    }
}
