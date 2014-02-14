<?php
$this->breadcrumbs = array(
    'Заказы',
);?>
<?php
Yii::import('application.web.widgets.pagers.*');
Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'));
$pager = array(
    'class' => 'DefaultLinkPager',
    'cssFile' => CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'),
    'header' => '',
    'prevPageLabel' => '&laquo;',
    'nextPageLabel' => '&raquo;',
);
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('reports', "
    $(document).ready(function(){
      control_url = '" . Yii::app()->createUrl('demands') . "/';
      base_url = '" . Yii::app()->request->baseUrl . "';
    });");
?>
<table class='tab_table'>
    <tr>

        <? if ($selected == 1) { ?>
        <td class="a_first" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Активные</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? } else { ?>
        <td class="n_first" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_1" style="width:120px" onclick="location.href='/demands/'">Активные</td>
        <td class="n_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? }?>

        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <? if ($selected == 2) { ?>
        <td class="a_left" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Внесена предоплата</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? } else { ?>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2" style="width:120px" onclick="location.href='/demands/finished'">Внесена предоплата</td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <? }?>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <? if ($selected == 3) { ?>
        <td class="a_left" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Расчет</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? } else { ?>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2" style="width:120px" onclick="location.href='/demands/profit'">Расчет</td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <? }?>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <? if ($selected == 4) { ?>
        <td class="a_left" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Срыв</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? } else { ?>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2" style="width:120px" onclick="location.href='/demands/failed'">Срыв</td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <? }?>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <? if ($selected == 5) { ?>
        <td class="a_left" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Архив</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <? } else { ?>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2" style="width:120px" onclick="location.href='/demands/archive'">Архив</td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <? }?>
        <td class="delim_2">
            <div>&nbsp;</div>
        </td>
        <td class="e_right">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<table style="WIDTH:100%" class='tab_table'>
    <tr>
        <td colspan="21" class="td_content">
            <div style="padding-bottom: 10px"><a style="font-size: 11px; margin-left: 15px" href="javascript:location.reload();">сбросить фильтры</a></div>
            <div class="demand_list_div">
                <?php $this->renderPartial($view, array('model' => $model, 'pager' => $pager)); ?>
            </div>
        </td>
        <!-- <td  class="td_content_right">&nbsp;</td>-->
    </tr>
    <tr>
        <td class="bott_left">
            <div>&nbsp;</div>
        </td>
        <td class="bott" colspan="19">&nbsp;</td>
        <td class="bott_right">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<div style="padding-top:20px;">
    <img src="/images/fn_left.gif" alt="" style="display:none">
</div>



 
