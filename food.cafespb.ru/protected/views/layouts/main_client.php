<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::app()->charset ?>"/>
    <meta name="language" content="ru"/>
<? Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui2/js/jquery-ui-1.8.9.custom.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.galleriffic.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.history.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.opacityrollover.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/multiselect/jquery.bgiframe.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/multiselect/jquery.multiSelect.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/js/multiselect/jquery.multiSelect.css");
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
                <div class="agent_place">
                    <?php $agent=$this->demand->Agent;?>
               <table width="400px">
                   <tr>
                       <td width="80px">
                           <?php if(!empty($agent->c_photo)){?><img src="/imgupload/staff/<?=$agent->c_photo?>" alt=""><?}?>
                       </td>
                       <td>
                           <div>Ваш персональный ассистент в подборе зала: <span class="brown"><?=$agent->c_name?></span></div>
                            <div>Личный телефон: <span class="brown"><?=$agent->c_phone?></span></div>
                           <div>Рабочий телефон: <span class="brown"><?=$agent->c_work_phone?></span></div>

                       </td>
                   </tr>
               </table>
                </div>
                <? if ($this->demand->is_demand_status==3||$this->demand->is_demand_status==4){?>
                <div class="offer_btn_place">
                   <table>
                       <tr>
                           <td>
                               <img src="/images/deny_offer.jpg" alt="" id="deny_offer">
                           </td>
                           <!--<td>
                               <img src="/images/confirm_offer.jpg" alt="" id="confirm_offer">
                           </td>-->
                       </tr>
                   </table>
                </div>
               <?}?>
                <!--<div style="position:absolute; color:red; top:50px; font-size:13px; left:-30px ">
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
