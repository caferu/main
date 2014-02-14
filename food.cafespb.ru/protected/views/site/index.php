<?php


$sql = "SELECT id from cf_object_100 where c_metka is null";
$command = Yii::app()->db->createCommand($sql);
$m= $command->queryColumn();
foreach ($m as $v) {
   $sql = "Update  cf_object_100 set c_metka = '".rand(1,10000000)."' where id=".$v;
$command = Yii::app()->db->createCommand($sql);
$command->query();
}

Yii::import('application.web.widgets.pagers.*');
//var_dump($read);
?>
<table class='tab_table'>
    <tr>
        <td class="a_first" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1" style="width:120px">Новости <?php if (!empty($read[3])) echo "(".$read[3].")";?></td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2" style="width:120px">Новые заведения <?php if (!empty($read[4])) echo "(".$read[4].")";?></td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <td class="n_left" id="tt_left_3">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_3" style="width:120px">Бонусы <?php if (!empty($read[9])) echo "(".$read[9].")";?></td>
        <td class="n_right" id="tt_right_3">
            <div>&nbsp;</div>
        </td>
        <!--  <td class="delim">
            <div>&nbsp;</div>
        </td>
       <td class="n_left" id="tt_left_4">
            <div>&nbsp;</div>
        </td>
       <td class="nact" id="tt_h_4" style="width:120px">Организация праздника</td>
        <td class="n_right" id="tt_right_4">
            <div>&nbsp;</div>
        </td>-->
        <td class="delim_2">
            <div>&nbsp;</div>
        </td>
        <td class="e_right">
            <div>&nbsp;</div>
        </td>
    </tr>
    </table>
    <table style="WIDTH:100%" class='tab_table' >
    <tr>
        <td colspan="13" class="td_content">
            <div id="tt_content_1" class='act_tt_div'>
                   <?
            $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $news->searchSite(),
                'itemView' => '_news',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));?>
            </div>
            <div id="tt_content_2" class='nact_tt_div'>
                 <?
            $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $resto->searchSite(),
                'itemView' => '_news',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));?>


            </div>
            <div id="tt_content_3" class='nact_tt_div'>
                 <?
            $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $bonus->searchSite(),
                'itemView' => '_news',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));?>


            </div>
            <!--<div id="tt_content_4" class='nact_tt_div'>
                <?
         /*   $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $demands->searchOrg(),
                'itemView' => '_org_fete',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));*/?>
            </div>-->
        </td>
        <!-- <td  class="td_content_right">&nbsp;</td>-->
    </tr>
    <tr>
        <td class="bott_left" >
            <div>&nbsp;</div>
        </td>
        <td class="bott" colspan="11">&nbsp;</td>
        <td class="bott_right">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    control_url = '/groups/'
    $(document).ready(function() {
        $('.nact').bind('click', change_tab);
    })
</script>
<div style="padding-top:20px;"
<img src="/images/fn_left.gif" alt="" style="display:none">
</div>