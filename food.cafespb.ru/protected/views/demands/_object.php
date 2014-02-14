<?
$sql = "Select point from cf_demand_object where id_demand=" . $demand->id . " and id_object=" . $model->id;
$command = Yii::app()->db->createCommand($sql);
$point = $command->queryScalar();
if ($point == 1 || $point == 2) $point_str = "<img src='/images/done_icon.png' class='img_done' alt=''>";
?>
<table width="100%" class="newsblock1">
    <tr>
        <td width="17"><img src="/images/cn1.jpg" alt="" width="17" height="13"></td>
        <td class="cn01" style="font-size:5px">&nbsp;</td>
        <td align="right" width="17"><img src="/images/cn2.jpg" alt="" width="17" height="13"></td>
    </tr>
    <tr>
        <td class="cn04"><img src="/images/cn1a.jpg" alt="" width="17" height="169"></td>
        <td class="cbg">
            <!--Блок заведения-->
            <table width="100%">
                <tr>
                    <td colspan="2" class="pad">
                        <table width="100%">
                            <tr>
                                <td width="15" height="39"><img src="/images/bgh1.png" alt="" width="15" height="39">
                                </td>
                                <td class="bgh" align="center" valign='top' width="80%">
                                    <span class='b_brown'
                                          style="font-size:13px; position:relative; top:10px; float:left; "><?= $model->c_name ?></span><?=$point_str?>
                                </td>
                                <td class="bgh brown" style="padding-top:11px;" nowrap>
                                    <? if ($point == 0) { ?> <span class="rem_cl_obj" id="remobj_1_<?=$model->id?>">Выбрать</span>
                                    <span class="conf_cl_obj" id="confobj_0_<?=$model->id?>">Отклонить</span><? }?>
                                </td>
                                <td align="right" width="15"><img src="/images/bgh2.png" alt="" width="15" height="39">
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td width="170px" style="padding-top:8px;">
                        <div style="background: url('http://cafespb.ru/imgupload/gallery/main/<?=$model->main_photo; ?>') no-repeat scroll center center transparent;"
                             class='ramka'>
                            <table>
                                <tr>
                                    <td class="clipper1"></td>
                                    <td align="center"><img src="/images/pict.png" class='r_image'
                                                            id='image_<?=$model->id?>' alt="" width="160"></td>
                                    <td class="clipper1"></td>
                                </tr>
                            </table>

                        </div>
                    </td>
                    <td width="100%" class="textblock"
                        style="text-align:left; padding-left:20px; vertical-align:top; padding-top:5px; ">
                        <strong>Район:</strong>&nbsp;&nbsp;<?=$model->Address->district->c_name;?><br>
                        <strong>Метро:</strong>&nbsp;&nbsp; <?=$model->s_metro?> <br>
                        <strong>Адрес:</strong>&nbsp;&nbsp; <?=$model->addr; ?> <br>
                        <? if (!empty($model->i_banket_bill)) { ?>
                        <strong>Счет на банкет:&nbsp;&nbsp; </strong>от <?=
                        $model->i_banket_bill
                        ; ?> руб. <br>
                        <? }?>
                        <? if (!empty($model->i_banket_bill_hot)) { ?>
                        <strong>Счет на банкет (сезон):&nbsp;&nbsp; </strong>от <?=
                        $model->i_banket_bill_hot
                        ; ?> руб. <br>
                        <? }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 3px; padding-left: 10px;  line-height: 150%">
                        <? if (!empty($model->Halls)) {
                        foreach ($model->Halls as $kk => $vv) {
                            if ($kk != 0) $t_str .= ', ';
                            $t_str .= ($kk + 1) . '-й зал - ' . $vv->i_qnt . ' мест';
                        }
                        ?>
                        <strong>Количество мест:</strong>&nbsp;&nbsp; <?=
                        $t_str ?> <br>
                        <? } ?>
                        <? if (!empty($model->c_alko)) { ?>
                        <strong>Свой алкоголь:</strong>&nbsp;&nbsp; <?=
                        $model->c_alko
                        ; ?> <br>
                        <? }?>
                        <? if (!empty($model->c_arenda)) { ?>
                        <strong>Аренда зала:</strong>&nbsp;&nbsp; <?=
                        $model->c_arenda
                        ; ?> <br>
                        <? }?>
                        <? if (!empty($model->c_service)) { ?>
                        <strong>Обслуживание:</strong>&nbsp;&nbsp; <?=
                        $model->c_service
                        ; ?> <br>
                        <? }?>
                        <? if (!empty($model->c_client_bonus)) { ?>
                        <strong>Бонусы для клиентов:</strong>&nbsp;&nbsp; <?=
                        $model->c_client_bonus
                        ; ?> <br>
                        <? }?>
                        <? if (!empty($model->c_equipment)) { ?>
                        <strong>Оборудование (свет, звук):</strong>&nbsp;&nbsp; <?= $model->c_equipment
                        ; ?> <br>
                        <? }?>
                        <strong>Прослушивание громкой музыки после 23 часов:</strong> <?=($model->b_music_night) ? 'да'
                            : 'нет';?><br>
                        <strong>Торжественное накрытие (юбки, чехлы):</strong> <?=($model->b_gala_cover) ? 'да'
                            : 'нет';?><br>
                        <strong>Детская комната:</strong> <?=($model->b_child_room) ? 'да' : 'нет';?><br>
                        <strong>Детское меню:</strong> <?=($model->b_child_menu) ? 'да' : 'нет';?><br>
                        <strong>Караоке:</strong> <?=($model->b_karaoke) ? 'да' : 'нет';?><br>
                        <? if (!empty($model->c_order_info)) { ?>
                        <strong>Контакт:</strong>&nbsp;&nbsp; <?=
                        $model->c_order_info
                        ; ?> <br>
                        <? }?>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td class="icontable" colspan='2' style='height:100px;'>
                        <?
                        if (!empty($model->photos)) {
                            foreach ($model->photos as $kk => $vv) {
                                if ($kk < 4) {
                                    ?>
                                    <img style='margin-left:10px; cursor:pointer' class='r_image'
                                         id='obj<?=rand(1, 1000);?>_<?=$model->id?>'
                                         src='http://www.cafespb.ru/imgupload/gallery/small/<?= $vv['c_source'] ?>'/>
                                    <?
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
        <td class="cn02"><img src="/images/cn2a.jpg" alt="" width="17" height="169"></td>
    </tr>
    <tr>
        <td><img src="/images/cn4.jpg" alt="" width="17" height="21"></td>
        <td class="cn03">&nbsp;</td>
        <td><img src="/images/cn3.jpg" alt="" width="17" height="21"></td>
    </tr>
</table> 