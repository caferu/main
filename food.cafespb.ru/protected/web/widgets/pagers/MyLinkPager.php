<?php
class MyLinkPager extends CLinkPager
{
    public function init()
    {
        $this->cssFile = false;
        $this->header  = false;

        $url = CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css');
        Yii::app()->getClientScript()->registerCssFile($url);

        parent::init();
    }

    public function run()
    {
        if ($this->getPageCount() > 1) {
            echo '<div class="pagination">';
            parent::run();
            echo '</div>';
        }
    }
}
