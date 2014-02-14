<div class="news" style="<? if ($index == 0) { ?>border-top:none;<? }?> <? if ($last) { ?>border-bottom:none;<? }?>">
    <div class="inner">
        <table style="width: 100%">
            <tr>
                <? if (!empty($data->c_photo)) { ?>
                <td style="width: 120px; padding-right: 10px">
                    <img src="/imgupload/messages/<?=$data->c_photo?>" alt="" style="border: solid 2px #dfdfdf">
                </td>
                <? }?>
                <td>
                    <div class="news_link"><a href="/<?=$data->c_url?>"><?=$data->c_header?></a></div>
                    <div>
                        <?=$data->t_anons?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
 
