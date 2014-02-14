<?
$classModel = get_class($data);
$cl = Yii::app()->getClientScript();
?>
<? if ($index == 0) { ?><div style=" display: table; width: 100%; "><? } ?>
<? if ($break) { ?></div><div style="display: table;width: 100%; "><? } ?>
<div class="goods" <? $clr = ''; if ($data->percent>10) $clr = '#ffdddd'; else if (!empty($data->isNotPayed)) $clr = '#fdfad2';
                      if (!empty($clr)) echo 'style="background-color: ' . $clr . '"'; ?>>
<table id="goods" style="<? if ($index % 4 == 0 && $index > 0) { ?>clear:both;<? }?>">
<tr>
    <td style="padding-left: 5px; padding-top: 2px; width: 99%">
        <div style="position:relative; left:-5px; white-space:nowrap; height: 24px">
            <div style="float: left">
                <input type='checkbox' class='pgoods' name='pgoods' value='<?=$data->id?>'>
                <b <? if (!empty($data->reserve_type)) { ?>style="color: red"<? }?>><?=$data->c_name;?> </b>
            </div>
            <div class="add_info" id="add_info_<?=$data->id?>">&nbsp;</div>
        </div>
        <table width="100%">
            <tr>
                <td width="210px">
                    <div style="background: url('http://cafespb.ru/imgupload/gallery/main/<?=$data->main_photo;?>') no-repeat scroll left top transparent;"
                         class='ramka2'>
                        <table>
                            <tr>
                                <td class="clipper1"></td>
                                <td align="center"><img src="/images/pict_2.png" class='r_image'
                                                        id='image_<?=$data->id?>' alt="" width="210px"></td>
                                <td class="clipper1"></td>
                            </tr>
                        </table>

                    </div>
                </td>
            </tr>
        </table>
        <div class="addr"><b><?=$data->addr;?></b></div>
        <div><b>Район:</b> <?=$data->Address->district->c_name;?></div>
    </td>
    <td>
        <div style="width:40px; height: 25px">
            <? if (isset(Yii::app()->user->CAN_EDIT_RESTO) && Yii::app()->user->CAN_EDIT_RESTO == 1) { ?>
            <div class="edit_info" id="edit_info_<?=$data->id?>">&nbsp;</div>
            <? }?>
        </div>
        <div class="icon_td" style="width: 100%; ">
            <? if (!empty($data->percent)) { ?>
            <div><img src="/images/<?=$data->percent?>_perc.gif" alt="7%"/></div>
            <? }?>
            <? if (!empty($data->c_info_mail)) { ?>
            <div><img src="/images/mail.gif" alt="E-mail" class="emailIcon"
                      id='emailIcon_<?=$data->id;?>'/></div>
            <div style='display:none' id='emailIcon_<?=$data->id;?>_tip'>
                <div class="add_info_content">
                    Email:&nbsp;&nbsp;<?= $data->c_info_mail; ?>
                </div>
            </div>
            <? }?>

            <? if (!empty($data->c_sms)) { ?>
            <div><img src="/images/sms.gif" alt="sms" class="smsIcon" id='smsIcon_<?=$data->id;?>'/></div>
            <div style='display:none' id='smsIcon_<?=$data->id;?>_tip'>
                <div class="add_info_content">
                    Телефон для sms:&nbsp;&nbsp;<?= $data->c_sms; ?>
                </div>
            </div>
            <? }?>
            <div>
                <? if (!empty($data->haveContract)) { ?>
                <img src='/images/bookmark_document.png' alt='договор' title="<?=$data->contractsInfo;?>"
                        />
                <? }?>
                <div style='display:none' id='add_info_<?=$data->id;?>_tip'>
                    <div class="add_info_content">
                        <? if (!empty($data->c_director_name)) { ?>
                        <div class="row">
                            <strong>Директор:</strong> <span
                                class='resto_param_value'><?=$data->c_director_name;?></span>
                        </div>
                        <? }?>
                        <? if (!empty($data->c_banket_admin)) { ?>
                        <div class="row">
                            <strong>Ответственный за банкеты:</strong> <span
                                class='resto_param_value'><?=$data->c_banket_admin;?></span>
                        </div>
                        <? }?>
                        <? if (!empty($data->c_work_time)) { ?>
                        <div class="row">
                            <strong>Время работы:</strong> <span
                                class='resto_param_value'><?=$data->c_work_time;?></span>
                        </div>
                        <? }?>
                        <? if (!empty($data->c_site_resto)) { ?>
                        <div class="row">
                            <strong>Сайт:</strong> <span
                                class='resto_param_value'>http://www.<?=$data->c_site_resto;?>
                        </div>
                        <? }?>
                        <? if (!empty($data->c_contact_info)) { ?>
                        <div class="row">
                            <strong>Контактная информация:</strong> <span
                                class='resto_param_value'><?=$data->c_contact_info;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_order_info)) { ?>
                        <div class="row">
                            <strong>Контакт для клиента:</strong> <span
                                class='resto_param_value'><?=$data->c_order_info;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_service)) { ?>
                        <div class="row">
                            <strong>Обслуживание:</strong> <span
                                class='resto_param_value'><?=$data->c_service;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_arenda)) { ?>
                        <div class="row">
                            <strong>Условия по закрытию площадки на банкет:</strong> <span
                                class='resto_param_value'><?=$data->c_arenda;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_alko)) { ?>
                        <div class="row">
                            <strong>Условия по алкоголю:</strong> <span
                                class='resto_param_value'><?=$data->c_alko;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_client_bonus)) { ?>
                        <div class="row">
                            <strong>Бонусы для клиентов:</strong> <span
                                class='resto_param_value'><?=$data->c_client_bonus;?></span>
                        </div>
                        <? } ?>
                        <? if (!empty($data->c_equipment)) { ?>
                        <div class="row">
                            <strong>Оборудование (свет, звук, его стоимость):</strong> <span
                                class='resto_param_value'><?=$data->c_equipment;?></span>
                        </div>
                        <? } ?>
                        <div class="row">
                            <strong>Прослушивание громкой музыки после 23 часов:</strong> <span
                                class='resto_param_value'><?=($data->b_music_night) ? 'да' : 'нет';?></span>
                        </div>
                        <div class="row">
                            <strong>Торжественное накрытие (юбки, чехлы):</strong> <span
                                class='resto_param_value'><?=($data->b_gala_cover) ? 'да' : 'нет';?></span>
                        </div>
                        <div class="row">
                            <strong>Детская комната:</strong> <span
                                class='resto_param_value'><?=($data->b_child_room) ? 'да' : 'нет';?></span>
                        </div>
                        <div class="row">
                            <strong>Детское меню:</strong> <span
                                class='resto_param_value'><?=($data->b_child_menu) ? 'да' : 'нет';?></span>
                        </div>
                        <div class="row">
                            <strong>Караоке:</strong> <span
                                class='resto_param_value'><?=($data->b_karaoke) ? 'да' : 'нет';?></span>
                        </div>
                    </div>
                </div>
                <div style='display:none' id='show_dates_<?=$data->id;?>_tip'>
                    <div class="add_info_content">
                        <? if (!empty($data->busy_dates)) {
                        ?>
                        <strong>Зарезервированные даты</strong>
                        <? foreach ($data->busy_dates as $v) {
                            $str = ($v->is_busy_date_type == 1) ? 'style="color:red"' : '';?>
                            <div <?=$str;?>><?=date('d.m.Y', strtotime($v->busy_date))?> <?=$v->t_comment?> <? $agent = (empty($v->id_user))?'заведение':$v->Agent->c_name; echo $agent;?></div>
                            <? } ?>
                        <? }?>
                    </div>
                </div>
                 <div style='display:none' id='show_comments_<?=$data->id;?>_tip'>
                    <div class="add_info_content">
                        <? if (!empty($data->bsComments)) {
                        ?>
                        <strong>Отзывы менеджеров</strong>
                        <? foreach ($data->bsComments as $v) {?>
                            <div style="white-space: nowrap"><?=date('d.m.Y', strtotime($v->t_create));?> <? $v->Agent->c_name?> <?=$v->Agent->c_name?>: <?=$v->t_comment?></div>
                            <? } ?>
                        <? }?>
                    </div>
                </div>

    </td>
</tr>
<tr>
    <td colspan="2" style="padding-left: 5px">
        <div><b>Метро:</b> <?=$data->s_metro;?></div>
        <div><b>Залы:</b> <?=$data->getPlanning(false);?></div>
        <? //if (!empty($data->i_banket_bill)) { ?>
        <div><b>Счет на банкет:</b> <?php if (!empty($data->i_banket_bill)) {
            echo $data->i_banket_bill . ' руб.';
        }?></div><?// }?>
        <? if (!empty($data->i_banket_bill_hot)) { ?>
        <div><b>Счет на банкет (высокий сезон):</b> <?php if (!empty($data->i_banket_bill_hot)) {
            echo $data->i_banket_bill_hot . ' руб.';
        }?></div><? }?>
        <div>
            <b>Телефоны: </b> <?=$data->c_phone;?>
        </div>
        <table style="width: 100%">
            <tr>
                <td>
                    <?php $icons = $data->getIconsParam();
                    if (!empty($icons)) {
                        ?>

                        <div class="icon_place_list">
                            <table class="icon_tbl">
                                <tr>
                                    <? foreach ($icons as $k => $v) {
                                    $ip = str_replace("gif", "png", $v['img']);?>
                                    <td>
                                        <img src="/img/param-icons/<?=$ip;?>" class="icon_tbl_img"
                                             alt="<?=$v['value'];?>" title="<?=$v['value'];?>"
                                             id='icon_<?=$k;?>_<?=$data->id;?>'>
                                    </td>
                                    <? }?>
                                </tr>
                            </table>
                        </div>
                        <? }?>
                </td>
                <td class="busy_date_comments">
                    <? $cntDates = $data->cntBusyDates;
                       $sCnt = (!empty($cntDates)) ? '(' . $cntDates . ')' : '';
                       $cls = (!empty($cntDates)) ? 'show_dates' : '';

                       $cntComments = $data->cntBsComments;
                       $ssCnt = (!empty($cntComments)) ? '(' . $cntComments . ')' : '';
                       $clss = (!empty($cntComments)) ? 'show_comments' : '';
                    ?>
                    <div class="<?=$cls;?> edit_busy_dates" id="show_dates_<?=$data->id?>"
                      id='busy_date_<?=$data->id;?>' >Даты <?=$sCnt?></div>
                    <div class="<?=$clss;?> edit_comments" id="show_comments_<?=$data->id?>"
                      id='comments_<?=$data->id;?>' >Отзывы <?=$ssCnt?></div>
                </td>
            </tr>
        </table>

    </td>
</tr>
</table>

</div>
<? if ($last) { ?></div><? } ?>