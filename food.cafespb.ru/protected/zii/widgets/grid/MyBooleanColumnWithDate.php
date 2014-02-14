<?php

class MyBooleanColumnWithDate extends CDataColumn {

    public $value;
    public $date;

    public function init() {
        $this->htmlOptions = array(
            'style' => 'width:1px;text-align:center;',
        );
    }

    protected function renderHeaderCellContent() {
        parent::renderHeaderCellContent();
    }

    protected function renderDataCellContent($row, $data) {
        $value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
        $date = $this->evaluateExpression($this->date, array('data' => $data, 'row' => $row));

        if (!is_array($date)) {
            $date = array($date);
        }

        $img = empty($value) ? 'cross.png' : 'tick.png';
        echo CHtml::image(Yii::app()->request->baseUrl . '/images/fugue/'.$img);
        if (!empty($date)) {
            echo "<br />".implode("<br />", $date);
        }
    }
}
