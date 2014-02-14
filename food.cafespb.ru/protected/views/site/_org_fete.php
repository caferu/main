<div class="org" style="<? if ($index == 0) { ?>border-top:none;<? }?> <? if ($last) { ?>border-bottom:none;<? }?>">
    <div class="inner">
        <div>
            <div>
                <span style="margin:0">Заказчик:</span> <?=$data->c_customer; ?> <span>Дата:</span> <?=date('d.m.Y', strtotime($data->date)); ?>
                <?php if (!empty($data->BanketType->c_name)){?><span>Мероприятие:</span> <?=$data->BanketType->c_name; ?><?}?>
                <?php if (!empty($data->i_person)){?><span>Количество человек:</span> <?=$data->i_person ?><?}?>
            </div>
            <div style="padding-top:2px">
                <span style="margin:0">E-mail:</span> <?=$data->c_mail; ?>
            </div>
        </div>
    </div>
</div>