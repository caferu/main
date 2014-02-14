<?php $this->beginContent('//layouts/main'); ?>
    <div id="work_content_2">
    <?php $this->widget('zii.widgets.CBreadcrumbs', array('homeLink' => '<a href="/">Главная</a>', 'links' => $this->breadcrumbs));?>
        <!-- breadcrumbs -->
    <?php echo $content; ?>
    </div>
<?php $this->endContent(); ?>
