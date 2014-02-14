<?php
Yii::import('application.zii.widgets.grid.*');

class ProfitGridView extends DefaultGridView {
    var $summaryCssClass = 'profitSummary';
    public $summaryText = "<div style='width: 100%'><span style='float:left'>{start}&mdash;{end} из {count}</span> <span style='float:right'><b>Получено: {profit} руб.</b></span></div>";

    	/**
	 * Renders the summary text.
	 */
	public function renderSummary()
	{
		if(($count=$this->dataProvider->getItemCount())<=0)
			return;

		echo '<div class="'.$this->summaryCssClass.'">';
        $data=$this->dataProvider->getData();
        $sum  = 0;
        foreach ($data as $v) {
            $sum += (int) $v->f_profit;
        }
        $sum = number_format($sum , 0, ',', ' ');

		if($this->enablePagination)
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
			$pagination=$this->dataProvider->getPagination();
			$total=$this->dataProvider->getTotalItemCount();
			$start=$pagination->currentPage*$pagination->pageSize+1;
			$end=$start+$count-1;
			if($end>$total)
			{
				$end=$total;
				$start=$end-$count+1;
			}
			echo strtr($summaryText,array(
				'{start}'=>$start,
				'{end}'=>$end,
				'{count}'=>$total,
				'{page}'=>$pagination->currentPage+1,
				'{pages}'=>$pagination->pageCount,
                '{profit}'=>$sum,
			));
		}
		else
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Total {count} result(s).');
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
                '{profit}'=>$sum,
			));
		}
		echo '</div>';
	}
}
 
