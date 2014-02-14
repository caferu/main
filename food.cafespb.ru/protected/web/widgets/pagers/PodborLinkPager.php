<? class PodborLinkPager extends CLinkPager {
    public $maxButtonCount = 10; 
        public function registerClientScript()
	{
        //print ($this->cssFile);
		if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);
	}

    protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="'.$class.'" onClick="gpage='.($page+1).'; podbor_obj();">'.CHtml::link($label,'#p').'</li>';
	}
}