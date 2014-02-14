<?php $this->beginContent('//layouts/main');
?>
<div>
    <table id="layout_table">
        <tr>
            <td id="left_column">
                <table class="left_demands_table">
                    <? foreach ($this->last_demands as $k => $v) { ?>
                    <tr>
                        <td class="ld_left<?=$v->status_class?>">
                            <div>&nbsp;</div>
                        </td>
                        <td class="ld_bg_pict<?=$v->is_banket_type?> ld_bg<?=$v->status_class?> ld_bg_common ">
                            <div>&nbsp;</div>
                        </td>
                        <td class="ld_bg<?=$v->status_class?> glaz <? if ($v->b_view_offer) { ?>act_glaz<? }?>">
                            <div>&nbsp;</div>
                        </td>
                        <td class="ld_bg<?=$v->status_class?> ld_bg_name">
                            <? $a_name = explode(' ', $v->c_customer); $name = $a_name[0];?>
                            <div><a href="javascript:get_demand(<?=$v->id;?>)"><?=$name?></a></div>
                        </td>
                        <td class="ld_bg<?=$v->status_class?> date">
                            <? if (!empty($v->date)) {
                            echo date('d.m', strtotime($v->date));
                        } else {
                            if (!empty($v->date_from)) {
                                echo date('d.m', strtotime($v->date_from));
                            }
                        }?>
                        </td>
                        <td class="ld_bg<?=$v->status_class?> <? if (!empty($v->t_user_comment)) { ?>coment<? }?>"
                            <? if (!empty($v->t_user_comment)) { ?>id='comment_<?=$v->id?>'<? }?> >
                            <div style="width:20px">&nbsp;</div>
                            <? if (!empty($v->t_user_comment)) { ?>
                            <div style='display:none' id='comment_<?=$v->id;?>_tip'><?=$v->t_user_comment?></div><? }?>
                        </td>
                        <td class="ld_right<?=$v->status_class?>">
                            <div>&nbsp;</div>
                        </td>

                    </tr>
                    <? } ?>
                    <tr>
                        <td class="ldlast_left">
                            <div>&nbsp;</div>
                        </td>
                        <td class="ldlast_bg" colspan="5">&nbsp; </td>
                        <td class="ldlast_right">
                            <div>&nbsp;</div>
                        </td>

                    </tr>
                </table>

            </td>
            <td>
                <div id="central_content">

                    <div id="work_content">
                        <?php $this->widget('zii.widgets.CBreadcrumbs', array('homeLink' => '<a href="/">Главная</a>', 'links' => $this->breadcrumbs));?>
                        <!-- breadcrumbs -->
                        <?php echo $content; ?>
                    </div>
                    <div class="copy">
                        <div>&copy; 2009 - <?php echo date('Y'); ?>  ООО "БОРДО".</div>
                        <img src="/images/decor.gif" alt="" id="decor"/>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php $this->endContent();
Yii::app()->clientScript->registerScript('catalog', "
$(document).ready(function(){
        $('.coment').tooltip({ bodyHandler: function() {
               return $('#'+$(this).attr('id')+'_tip').html();
          },  showURL: false});
          });");
?>