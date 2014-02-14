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
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/tooltip/jquery.tooltip.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/tooltip/jquery.tooltip.css');

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
                <div class="owner_place">
                 <?=$this->resto->l_name;?><br>
                 <?=$this->resto->addr;?>
                </div>
                <div class="adv_owner_place">
                 Рекламный отдел: 986-35-24<br>
                 Банкетная служба: 244-25-80<br>
                </div>
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
