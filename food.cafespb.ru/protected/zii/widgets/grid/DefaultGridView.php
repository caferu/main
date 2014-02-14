<?php

Yii::import('zii.widgets.grid.CGridView');

class DefaultGridView extends CGridView {
    public $showTableOnEmpty = true;
    public $ajaxUpdate = true;
    public $selectableRows = 1;
    public $enableSorting = false;
    public $enablePagination = true;
    public $pager = "application.web.widgets.pagers.DefaultLinkPager";
    public $summaryText = "{start}&mdash;{end} из {count}";
    public $template = "{items}\n{summary}\n{pager}";
    public $rowCssClass=array('odd','even');

    public function init() {
        $this->baseScriptUrl = Yii::app()->request->baseUrl . '/css/widgets/gridview';
        if($this->dataProvider!==null) {
           // $this->dataProvider->pagination->pageSize = $this->pager[pageSize];
        }
        parent::init();
    }

    public function renderTableRow($row)
	{
		if($this->rowCssClassExpression!==null)
		{
			$data=$this->dataProvider->data[$row];
			echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
		}
		else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0){
            $data=$this->dataProvider->data[$row];
            $class=$this->rowCssClass[$row%$n];
           // if ($data->is_demand_status==3) $class.=' g_sended';
           // if ($data->is_demand_status==4) $class.=' g_recived';
           // if ($data->is_demand_status==5) $class.=' g_paid';
           // if ($data->is_demand_status==9) $class.=' g_new_offer';
			echo '<tr class="'.$class.'">';
        }
		else
			echo '<tr>';
		foreach($this->columns as $column)
			$column->renderDataCell($row);
		echo "</tr>\n";
	}
}
