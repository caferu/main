<div class="dash2" style="margin-top: 10px">&nbsp;</div>
<h3 class="r_header">Фотогалерея</h3>

<div>&nbsp;</div>
<div style="width: 95%; padding-left: 3%;">
    <div style="font-size: 12px; color: #414141 ">
        <?php
                $cnt = count($gallery);
        if ($cnt > 1) {
            echo 'Выберите: ';
        }      // var_dump($gallery);
        $i = 0;
        foreach ($gallery as $k => $v) {

            $l = ($cnt == 1) ? 13 : 7;
            $cls = ($i == 0) ? "rgh_active2" : "rgh_inactive2";
            $i++;
            if ($cnt > 1) {
                $name = "<span class='rgh_div2 " . $cls . "' id='rgh_" . $i . "'>" . mb_strtolower($v['name'], 'utf-8') . "</span>";
                if (($i + 1) <= $cnt) $name .= ', '; else $name .= '';
            } else {
                $name = "<span class='rgh_div2 " . $cls . "'>" . $v['name'] . "</span>";
            }
            echo $name;
        }
        ?>
    </div>
    <center>
        <div style="height: 120px; width: auto; display: table-cell;">

        <?php
                                                                            $i = 0;
            foreach ($gallery as $v) {
                $cls = ($i == 0) ? "rg_photos rg_photos_active" : "rg_photos rg_photos_inactive";
                $i++;
                ?>
                <div class="<?=$cls?>" id='rgp_<?=$i;?>'>
                    <?php foreach ($v['photos'] as $kk => $vv) {
                    if ($kk < 7) {
                        ?>
                        <div class="rg_ramka2 rgbind" id="rgp_<?=$vv->is_image_type;?>_<?=$kk;?>">
                            <div id="rgp_<?=$vv->is_image_type;?>_<?=$kk;?>"
                                    >
                                <img class="mh" src="http://cafespb.ru/imgupload/gallery/small/<?=$vv->c_source;?>"
                                     alt="" id="rgp_<?=$vv->is_image_type;?>_<?=$kk;?>">
                            </div>
                        </div>
                        <?
                    }
                }
                    ?>
                </div>
                <? }?>

        </div>
    </center>

</div>
<?
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/desaturate/jQuery.desaturate.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.galleriffic.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/css/galleriffic-4.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/galleriffic-2.0/js/jquery.opacityrollover.js');
Yii::app()->getClientScript()->registerScript('gallery', "

				
$('.rgh_inactive2').bind('click',tab_rgallery2);
$('.rgbind').bind('click',showGallery);
");

?>
 
