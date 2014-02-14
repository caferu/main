<div class="news" style="<? if ($index == 0) { ?>border-top:none;<? }?> <? if ($last) { ?>border-bottom:none;<? }?>">
    <div class="inner">
        <div class="news_link" ><a id="group_<?=$data->id?>" href="javascript:show_group(<?=$data->id?>);"><?=$data->c_name?></a></div>
        <div>
        Количество заведений: <?=count($data->objects);?>
        </div>
    </div>
</div>
