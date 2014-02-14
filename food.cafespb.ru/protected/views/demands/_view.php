<div class="goods">
    <table id="goods" style="<? if ($index % 4 == 0 && $index > 0) { ?>clear:both;<? }?>">
        <tr>
            <td class="resto_card_left">
                <div>&nbsp;</div>
            </td>
            <td class="resto_card_bg">
                <div style="position:relative; left:-5px; white-space:nowrap;">
                    <input type='checkbox' class='pgoods' name='pgoods' value='<?=$data->id?>'>
                    <b <? if (!empty($data->reserve_type)){?>style="color: red"<?}?>><?=$data->c_name?> </b>
                <? if (isset(Yii::app()->user->CAN_EDIT_RESTO)&&Yii::app()->user->CAN_EDIT_RESTO == 1) { ?>
                    <div class="edit_info" id="edit_info_<?=$data->id?>">&nbsp;</div>
                <? }?>
                </div>
                <div style="width:240px; position:relative; left:12px; top:2px">
                    <table width="100%">
                        <tr>
                            <td width="170px">
                                <div style="background: url('http://cafespb.ru/imgupload/gallery/main/<?=$data->gallery['main'];?>') no-repeat scroll left top transparent;"
                                     class='ramka'>
                                    <table>
                                        <tr>
                                            <td class="clipper1"></td>
                                            <td align="center"><img src="/images/pict.png" class='r_image'
                                                                    id='image_<?=$data->id?>' alt="" width="160"></td>
                                            <td class="clipper1"></td>
                                        </tr>
                                    </table>

                                </div>
                            </td>
                            <td class="icon_td">
                            <? if (!empty($data->i_percent)) { ?>
                                <div><img src="/images/<?=$data->i_percent?>_perc.gif" alt="7%"/></div>
                            <? }?>
                            <? if (!empty($data->info_mail)) { ?>
                                <div><img src="/images/mail.gif" alt="E-mail"/></div>
                            <? }?>
                            <? if (!empty($data->c_sms)) { ?>
                                <div><img src="/images/sms.gif" alt="sms"/></div>
                            <? }?>
                            </td>
                        </tr>
                    </table>
                     <div class="addr"><b><?=$data->addr;?></b>
                     <? if (!empty($data->c_alco)||!empty($data->c_arenda)||!empty($data->c_service)||!empty($data->contact_info)||!empty($data->busy_dates)){?>
                        <div class="add_info" id="add_info_<?=$data->id?>">&nbsp;</div>
                  <?}?>

                    </div>
                    <div><b>Район:</b> <?=$data->s_distr;?></div>
                    <div><b>Метро:</b> <?=$data->s_a6n;?></div>

                    <div><b>Залы:</b> <?=$data->c_planning;?></div>
                     <? if (!empty($data->banket_bill)) {?>  <div><b>Счет на банкет:</b> <?php if (!empty($data->banket_bill)) {
                            echo $data->banket_bill . ' руб.';
                        }?></div><?}?>


                    <div style='display:none' id='add_info_<?=$data->id;?>_tip'>
                        <div class="add_info_content">

                          <? if (!empty($data->c_alco)) { ?>
                        Свой алкоголь:&nbsp;&nbsp;<?=
                    $data->c_alco
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
                    ; ?><br><?}?>
                    <? if (!empty($data->contact_info)) { ?>
                       Контактная информация:&nbsp;&nbsp; <?=
                    $data->contact_info
                    ; ?><br><?}
                     if (!empty($data->busy_dates)){?>
                             <strong>Зарезервированные даты</strong>
                         <? foreach ($data->busy_dates as $v){
                             $str = ($v->is_busy_date_type==1)?'style="color:red"':'';?>
                            <div <?=$str;?>><?=date('d.m.Y',strtotime($v->busy_date))?> <?=$v->t_comment?></div>
                       <?  }?>
                             <?}?>


                </div>
                        </div>
            </td>
            <td class="resto_card_right">
                <div>&nbsp;</div>
            </td>
        </tr>
    </table>

</div>