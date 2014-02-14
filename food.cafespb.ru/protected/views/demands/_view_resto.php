<div class="goods">
    <table id="goods" style="<? if ($index % 4 == 0 && $index > 0) { ?>clear:both;<? }?>">
        <tr>
            <td style="padding-left: 5px; padding-top: 2px; width: 99%">
                <table width="100%">
                    <tr>
                        <td>
                            <div style="position:relative; left:-5px; white-space:nowrap; height: 24px">
                                <input type='checkbox' class='pgoods' name='pgoods' value='<?=$data->id?>'>
                                <b <? if (!empty($data->reserve_type)) { ?>style="color: red"<? }?>><?=$data->l_name?> </b>
                            </div>
                        </td>
                    </tr>
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
                <div><b>Метро:</b> <?=$data->s_metro;?></div>
                <div><b>Залы:</b> <?=$data->planning;?></div>
                <? if (!empty($data->i_banket_bill)) { ?>
                <div><b>Счет на банкет:</b> <?php if (!empty($data->i_banket_bill)) {
                    echo $data->i_banket_bill . ' руб.';
                }?></div><? }?>

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
                    <div><img src="/images/sms.gif" alt="sms"/></div>
                    <? }?>
                    <div>
                        <? if (!empty($data->haveContract)) { ?>
                        <img src='/images/bookmark_document.png' alt='договор' title="Договор"
                                />
                        <? }?>
                        <? if (!empty($data->c_alco) || !empty($data->c_arenda) || !empty($data->c_service) || !empty($data->c_contact_info) || !empty($data->busy_dates) || !empty($data->c_order_info)) { ?>
                        <div class="add_info" id="add_info_<?=$data->id?>">&nbsp;</div>
                        <? }?>
                       <div >
                            <a href="/site/viewResto/id/<?=$data->id?>" target="_blank">
                                <img src='/images/viewmag.png' alt='подробнее' title="Подробная информация"/>
                            </a>
                        </div>
                        <div style='display:none' id='add_info_<?=$data->id;?>_tip'>
                            <div class="add_info_content">

                                <? if (!empty($data->c_alko)) { ?>
                                Свой алкоголь:&nbsp;&nbsp;<?=
                                $data->c_alko
                                ; ?><br>
                                <? }?>
                                <? if (!empty($data->c_arenda)) { ?>
                                Аренда зала:&nbsp;&nbsp;<?=
                                $data->c_arenda
                                ; ?><br>
                                <? }?>
                                <? if (!empty($data->c_service)) { ?>
                                Обслуживание:&nbsp;&nbsp; <?=
                                $data->c_service
                                ; ?><br><? }?>
                                <? if (!empty($data->c_contact_info)) { ?>
                                Контактная информация:&nbsp;&nbsp; <?=
                                $data->c_contact_info
                                ; ?><br><?
                            }
                                if (!empty($data->c_order_info)) {
                                    ?>
                                    Контакт (для клиента):&nbsp;&nbsp; <?=
                                    $data->c_order_info
                                    ; ?><br><?
                                }
                                if (!empty($data->busy_dates)) {
                                    ?>
                                    <strong>Зарезервированные даты</strong>
                                    <? foreach ($data->busy_dates as $v) {
                                        $str = ($v->is_busy_date_type == 1) ? 'style="color:red"' : '';?>
                                        <div <?=$str;?>><?=date('d.m.Y', strtotime($v->busy_date))?> <?=$v->Agent->c_name?> <?=$v->t_comment?></div>
                                        <? } ?>
                                    <? }?>


                            </div>
                        </div>

            </td>
        </tr>
    </table>

</div>