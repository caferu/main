<?php

class DefaultLinkPager extends CLinkPager {
    public $maxButtonCount = 10;
        public function registerClientScript()
	{
        print ($this->cssFile);
		if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);
	}
}
