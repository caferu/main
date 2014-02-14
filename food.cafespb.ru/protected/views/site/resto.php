<?php
$links = array();
$links[$model->l_name] = '';
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.simplemodal.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/resto.css');
Yii::app()->getClientScript()->registerScript('main', "
ID_OBJECT=" . $model->id . ";
");
$coord = $model->Coord;
if (!empty($coord)) {
    // $facad =(!empty($model->facad))?'<div class="facad_div"><img src="http://cafespb.ru/imgupload/gallery/facad/'.$model->facad.'"></div>':'';
    Yii::app()->getClientScript()->registerScriptFile("http://api-maps.yandex.ru/1.1/index.xml?key=" . $this->api_map);
    Yii::app()->getClientScript()->registerScript('map', "
f_lat=" . $coord->f_lat . ";
f_lng=" . $coord->f_lng . ";
caption=\"" . addslashes($model->mapName) . "<br><i style=\'font-size:11px\'>" . $model->getAddress() . "</i>\";
var map = new YMaps.Map($('#Ymap')[0]);
            map.setCenter(new YMaps.GeoPoint(f_lat, f_lng), 14);
            var placemark = new YMaps.Placemark(new YMaps.GeoPoint(f_lat, f_lng),{hideIcon:false, hasBalloon: false});
            placemark.setIconContent(caption);

            map.addOverlay(placemark);
            map.addControl(new YMaps.Zoom(), new YMaps.ControlPosition(YMaps.ControlPosition.BOTTOM_LEFT, new YMaps.Point(10, 10)));
");
}?>
<div class="content_place">
<table id="ra_table">
    <tr>
        <td class="ra_td_left2">
            <div>&nbsp;</div>
        </td>
        <td class="ra_td_bg2" style="text-align: left; padding-top: 13px">
            <?=$model->l_name; ?>
        </td>
        <td class="ra_td_right2">
            <div>&nbsp;</div>
        </td>
    </tr>
</table>
<table id="rc_table">
<tr>
<td class="rtc_td_left">
    <div>&nbsp;</div>
</td>
<td class="rtc_td_bg">
<div class="resto_info">
<div class='main_resto_info'>
<table style="width: 100%">
<tr>
<td width="35%">
    <div class="row">
        <strong>Район:</strong> <span
            class="grey_link"><?=$model->Address->district->c_name; ?></span>
    </div>
    <div class="row">
        <strong>Метро:</strong> <?=$model->getMetroLinks();?>
    </div>
    <div class="row">
        <strong>Адрес:</strong> <span
            class='resto_param_value'><?=$model->getAddress();?><span>
    </div>
    <div class="row">
        <strong>Договор:</strong> <span
            class='resto_param_value'><?=$model->contractsInfo;?></span>
    </div>
    <div class="row">
        <strong>Комиссионные:</strong> <span
            class='resto_param_value'><?=$model->percent;?>%</span>
    </div>
    <div class="row">
        <strong>Количество мест:</strong> <span
            class='resto_param_value'><?=$model->getPlanning(false);?><span>
    </div>
    <? if (!empty($model->c_director_name)) { ?>
    <div class="row">
        <strong>Директор:</strong> <span
            class='resto_param_value'><?=$model->c_director_name;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_banket_admin)) { ?>
    <div class="row">
        <strong>Ответственный за банкеты:</strong> <span
            class='resto_param_value'><?=$model->c_banket_admin;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_phone)) { ?>
    <div class="row">
        <strong>Телефоны:</strong> <span
            class='resto_param_value'><?=$model->c_phone;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_work_time)) { ?>
    <div class="row">
        <strong>Время работы:</strong> <span
            class='resto_param_value'><?=$model->c_work_time;?></span>
    </div>
    <? }?>
    <div class="row">
        <strong>Счет на банкет (низкий сезон/высокий сезон):</strong> <span
            class='resto_param_value'><?=$model->i_banket_bill;?>/<?=(!empty($model->i_banket_bill_hot))?$model->i_banket_bill_hot:'-';?> р.
        </span>
    </div>
    <div class="row">
        <strong>Email для заявок, оповещений:</strong> <span
            class='resto_param_value'><?=$model->c_info_mail;?></span>
    </div>
    <div class="row">
        <strong>Телефон для sms-оповещений:</strong> <span
            class='resto_param_value'><?=$model->c_sms;?></span>
    </div>
    <? if (!empty($model->c_site_resto)) { ?>
    <div class="row">
        <strong>Сайт:</strong> <span
            class='resto_param_value'><a target="_blank"
                                         href='http://www.<?=$model->c_site_resto;?>'>http://www.<?=$model->c_site_resto;?></a>
    </div>
    <? }?>

    <?php $icons = $model->getIconsParam();
    if (!empty($icons)) {
        Yii::app()->getClientScript()->registerScript('icon', "
                                        icons = " . json_encode($icons) . ";
                                        $('.icon_tbl img').bind('mouseover', show_icon_tip);
                                        $('.icon_tbl img').bind('mouseout', hide_icon_tip);
                                        ");

        ?>
        <div class="icon_place">
            <table class="rtp">
                <tr>
                    <td class="td_left">
                        <div>&nbsp;</div>
                    </td>
                    <td class="td_bg"></td>
                    <td class="td_right">
                        <div>&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="htip"><img src="/img/htip.gif"
                                                      alt=""/></td>
                </tr>
            </table>
            <table class="icon_tbl">
                <tr>
                    <? foreach ($icons as $k => $v) { ?>
                    <td>
                        <img src="/img/<?=$v['img'];?>"
                             alt="<?=$v['value'];?>" id='icon_<?=$k;?>'>
                    </td>
                    <? }?>
                </tr>
            </table>
        </div>
        <? }?>
</td>

<td width="30%">
    <? if (!empty($model->c_contact_info)) { ?>
    <div class="row">
        <strong>Контактная информация:</strong> <span
            class='resto_param_value'><?=$model->c_contact_info;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_order_info)) { ?>
    <div class="row">
        <strong>Контакт для клиента:</strong> <span
            class='resto_param_value'><?=$model->c_order_info;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_service)) { ?>
    <div class="row">
        <strong>Обслуживание:</strong> <span
            class='resto_param_value'><?=$model->c_service;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_arenda)) { ?>
    <div class="row">
        <strong>Условия по закрытию площадки на банкет:</strong> <span
            class='resto_param_value'><?=$model->c_arenda;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_alko)) { ?>
    <div class="row">
        <strong>Условия по алкоголю:</strong> <span
            class='resto_param_value'><?=$model->c_alko;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_client_bonus)) { ?>
    <div class="row">
        <strong>Бонусы для клиентов:</strong> <span
            class='resto_param_value'><?=$model->c_client_bonus;?></span>
    </div>
    <? }?>
    <? if (!empty($model->c_equipment)) { ?>
    <div class="row">
        <strong>Оборудование (свет, звук, его стоимость):</strong> <span
            class='resto_param_value'><?=$model->c_equipment;?></span>
    </div>
    <? }?>
    <div class="row">
        <strong>Прослушивание громкой музыки после 23 часов:</strong> <span
            class='resto_param_value'><?=($model->b_music_night) ? 'да' : 'нет';?></span>
    </div>
    <div class="row">
        <strong>Торжественное накрытие (юбки, чехлы):</strong> <span
            class='resto_param_value'><?=($model->b_gala_cover) ? 'да' : 'нет';?></span>
    </div>
    <div class="row">
        <strong>Детская комната:</strong> <span
            class='resto_param_value'><?=($model->b_child_room) ? 'да' : 'нет';?></span>
    </div>
    <div class="row">
        <strong>Детское меню:</strong> <span
            class='resto_param_value'><?=($model->b_child_menu) ? 'да' : 'нет';?></span>
    </div>
    <div class="row">
        <strong>Караоке:</strong> <span
            class='resto_param_value'><?=($model->b_karaoke) ? 'да' : 'нет';?></span>
    </div>
    <?php $cards = $model->CreditCards;
    if (!empty($cards)) {
        ?>
        <table class="resto_sp_tbl">
            <td width="50%" style="position: relative;">


                <div class="credit_cards">
                    Принимаем карты:
                </div>
                <div class="credit_cards">
                    <? foreach ($cards as $v) { ?>
                    <img src="/img/payment-icons/<?=$v->c_icon_file?>"
                         alt="<?=$v->c_name?>">
                    <? }?>
                </div>

            </td>
        </table>
        <? }?>
</td>

<?php if (!empty($coord)) { ?>
<td width="35%">

    <div id='map_container'>
        <div id="Ymap">&nbsp;</div>
    </div>
</td>
    <? }?>
</tr>
</table>

</div>
<?php $gallery = $model->getGallery();
if (!empty($gallery)) $this->renderPartial('_gallery', array('gallery' => $gallery));
?>
<? if (!empty($model->t_descr)) { ?>
<div class="dash2" style="margin-top: 10px">&nbsp;</div>
<h3 class="r_header">О заведении</h3>

<div class="main_resto_info"><?php echo $model->t_descr;?></div>
    <? } ?>
<? if (!empty($model->pages)) {
    foreach ($model->pages as $v) {
        ?>
    <div class="dash2" style="margin-top: 10px" id="rpage_<?php echo $v->id;?>">&nbsp;</div>
    <h3 class="r_header"><?=$v->c_header?></h3>

    <div class="main_resto_info"><?php echo $v->t_content;?></div>
        <?
    }
}?>
</div>
</td>
<td class="rtc_td_right">
    <div>&nbsp;</div>
</td>
</tr>
<tr>
    <td class="rtb_td_left">
        <div>&nbsp;</div>
    </td>
    <td class="rtb_td_bg">&nbsp;</td>
    <td class="rtb_td_right">
        <div>&nbsp;</div>
    </td>
</tr>
</table>
</div>
<div id="galleryPlace" class="modal">

</div>
<!-- preload the images -->
<div style='display:none'>
    <img src='/img/x.png' alt=''/>
</div>