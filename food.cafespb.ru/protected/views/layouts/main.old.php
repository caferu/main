<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::app()->charset ?>"/>
    <meta name="language" content="ru"/>
<? Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui2/js/jquery-ui-1.8.9.custom.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui/js/jquery-ui.datepicker-ru.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.galleriffic.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.history.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.opacityrollover.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/multiselect/jquery.bgiframe.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/multiselect/jquery.multiSelect.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/js/multiselect/jquery.multiSelect.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/tooltip/jquery.tooltip.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/tooltip/jquery.tooltip.css');
$o_str = (!empty($_GET['open_demand']))?'open_demand='.$_GET['open_demand'].';':'';
$demand_height = 360 + ($this->cnt_obj/4)*255;
Yii::app()->clientScript->registerScript('open',
        'is_new_window='.(int)$this->is_new_window.";
        demand_height = ".$demand_height.";
         ".$o_str);

?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui2/css/smoothness/jquery-ui-1.8.9.custom.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/js/galleriffic-2.0/css/galleriffic-4.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


<table style="width:100%">
    <tr>
        <td class="main_empty_field_left" rowspan="2"><div class="white_div">&nbsp;</div></td>
        <td class="main_empty_field_left_2">
            <div>&nbsp;</div>
        </td>
        <td id="main_column_2" rowspan="2">
            <img src="/images/logo_2.jpg" alt="Логотип" id="logo_2">

            <div class='content2'>
                <?php if (Yii::app()->user->CF_STATUS == 1) {?>
                 <div class="head_left_links">
                    <a href="http://cafespb.ru" target="_blank" class="username">cafespb.ru</a> <? echo $this->stat_demands[1]['m']?> (<? echo $this->stat_demands[1]['y']?>)&nbsp;&nbsp;|&nbsp;&nbsp;<a
                    <a href="http://gorodovoy.spb.ru" target="_blank" class="username">gorodovoy.spb.ru</a> <? echo $this->stat_demands[5]['m']?> (<? echo $this->stat_demands[5]['y']?>)&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="http://peterburg2.ru" target="_blank" class="username">peterburg2.ru</a> <? echo $this->stat_demands[6]['m']?> (<? echo $this->stat_demands[6]['y']?>)
                </div>

                <?}?>
                <div class="head_right_links">
                    <a href="<?=$this->createUrl('site/user');?>" class="username"><?=Yii::app()->user->name;?></a>
                    <a href="<?=$this->createUrl('site/preferences');?>" id="a_pref"><img src="/images/pref.gif" alt="Настройки"></a>| <a
                        href="<?=$this->createUrl('site/logout');?>" class="logout">Выход</a>
                </div>
                <div class="menu">
                <? $mi = ($this->menu == 1) ? 'a' : 'n';?>
                    <div class="main <?=$mi;?>_main">&nbsp;</div>
                <? $mi = ($this->menu == 2) ? 'a' : 'n';?>
                    <div class="add_order <?=$mi;?>_add_order">&nbsp;</div>
                <? $mi = ($this->menu == 3) ? 'a' : 'n';?>
                    <div class="groups <?=$mi;?>_groups">&nbsp;</div>
                <? $mi = ($this->menu == 4) ? 'a' : 'n';?>
                    <div class="demands <?=$mi;?>_demands">&nbsp;</div>
                </div>
         <!--       <div style="position:absolute; color:red; top:50px; font-size:13px; left:-30px ">
                    Внимание! В систему вносятся изменения! Возможны сбои в работе.
                </div>-->
            </div>
            <?php echo $content; ?>
        </td>
        <td class="main_empty_field_right_2">
            <div>&nbsp;</div>
        </td>
        <td class="main_empty_field_right" rowspan="2"><div class="white_div">&nbsp;</div></td>
    </tr>
    <tr>
        <td class="td_left_3">&nbsp;</td>
        <td></td>
    </tr>
    <tr>
        <td class="td_left_4">&nbsp;</td>
        <td colspan="3" class="td_bg_4"></td>
        <td class="td_right_4">&nbsp;</td>
    </tr>
</table>
<div id="dialog_object"></div>
<div id="dialog_object2"></div>
</body>
</html>
