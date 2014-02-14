<?php Yii::import('application.web.widgets.pagers.*'); ?>
<span class='redlink' id="add_group">Добавить группу</span>
<table class='tab_table'>
    <tr>
        <td class="a_first" id="tt_left_1">
            <div>&nbsp;</div>
        </td>
        <td class="act" id="tt_h_1">Мои группы</td>
        <td class="a_right" id="tt_right_1">
            <div>&nbsp;</div>
        </td>
        <td class="delim">
            <div>&nbsp;</div>
        </td>
        <td class="n_left" id="tt_left_2">
            <div>&nbsp;</div>
        </td>
        <td class="nact" id="tt_h_2">Группы банкетной службы</td>
        <td class="n_right" id="tt_right_2">
            <div>&nbsp;</div>
        </td>
        <td class="delim_2">
            <div>&nbsp;</div>
        </td>
        <td class="e_right">
            <div>&nbsp;</div>
        </td>
    </tr>
    <tr>
        <td colspan="9" class="td_content">
            <div id="tt_content_1" class='act_tt_div'>
            <?
            $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $my_groups->actual()->search(),
                'itemView' => '_groups',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));?>
                <div class="group_anons">
                    Если Вам нужна помощь по настройке групп,<br>
                    обратитесь в отдел тех. поддержки по телефону
                    <div class="phone">986-35-24</div>
                </div>


            </div>
            <div id="tt_content_2" class='nact_tt_div'>
            <?
            $this->widget('application.zii.widgets.MyCListView', array(
                'dataProvider' => $common->actual()->search(),
                'itemView' => '_groups',
                'template' => "{pager}\n{sorter}\n{items}",
                'ajaxUpdate' => true,
                'pager' => $pager
            ));?>
                <div class="group_anons">
                    Если Вам нужна помощь по настройке групп,<br>
                    обратитесь в отдел тех. поддержки по телефону
                    <div class="phone">986-35-24</div>
                </div>

            </div>
        </td>
        <!-- <td  class="td_content_right">&nbsp;</td>-->
    </tr>
    <tr>
        <td class="bott_left">
            <div>&nbsp;</div>
        </td>
        <td class="bott" colspan="7">&nbsp;</td>
        <td class="bott_right">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    control_url = '/groups/'
    $(document).ready(function() {
        $('.nact').bind('click', change_tab);
        $('#add_group').bind('click',add_group);
    })
</script>
<img src="/images/fn_left.gif" alt="" style="display:none">
