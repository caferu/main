<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::app()->charset ?>"/>
    <meta name="language" content="ru"/>
    <? Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCssFile('/js/jquery-ui2/css/smoothness/jquery-ui-1.8.9.custom.css');
    Yii::app()->clientScript->registerScriptFile('/js/main.js');?>
    <? Yii::app()->clientScript->registerCssFile('/css/forms.css');?>
    <? Yii::app()->clientScript->registerCssFile('/css/buttons.css');?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


<table style="width:100%">
    <tr>
        <td class="main_empty_field_left_2">
            <div>&nbsp;</div>
        </td>
        <td id="main_column_3" rowspan="2">
            <!--            <img src="/images/logo_2.jpg" alt="Логотип" id="logo_2">-->

            <div class='content2'>
                <div class="head_right_links2">
                    <a href="<?=$this->createUrl('site/logout');?>" class="logout">Выход</a>
                </div>
                <div class="menu2">
                    <table>
                        <tr>
                            <? $mi = ($this->menu == 1) ? 'a' : '';?>
                            <td style="padding-left: 50px">
                                <div class="item <?=$mi;?>"><a href="/demands">Заказы</a></div>
                            </td>
                            <? $mi = ($this->menu == 2) ? 'a' : '';?>
                            <td>
                                <div class="item <?=$mi;?>"><a href="/foodVendors">Рестораны</a></div>
                            </td>
                            <? $mi = ($this->menu == 3) ? 'a' : '';?>
                            <td>
                                <div class="item <?=$mi;?>"><a href="/foodOffers">Меню</a></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--             <div style="position:absolute; color:red; top:50px; font-size:13px; left:30px ">
                    Внимание! В систему вносятся изменения! Возможны сбои в работе.
                </div>-->
            </div>
            <?php echo $content; ?>
        </td>
        <td class="main_empty_field_right_2">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<div id="dialog_object"></div>
<div id="dialog_object2"></div>
</body>
</html>
