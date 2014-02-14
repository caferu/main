<div id="content_place">
    <h1><?=$model->c_header;?></h1>
<?=$model->t_content;?>
    <? if ($model->Tape->b_date){?>
        <div class="date1">
            <?=date('d.m.Y',strtotime($model->date));?>
        </div>
    <?}?>
</div>
 
