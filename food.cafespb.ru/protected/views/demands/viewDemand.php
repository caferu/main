<?
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.simplemodal.js');
Yii::app()->clientScript->registerScriptFile('/js/jquery.chosen.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/chosen.css');
$iconPath = Yii::app()->request->baseUrl.'/images/';
$autocompleteConfig = array(
    'model' => $model, // модель
    'attribute' => 'id_resto',
    'source' => Yii::app()->createUrl('Demands/getAllResto'),
    'options' => array(
        // минимальное кол-во символов, после которого начнется поиск
        'minLength' => '2',
        'showAnim' => 'fold',
        // обработчик события, выбор пункта из списка
        'select' => 'js: function(event, ui) {
            // действие по умолчанию, значение текстового поля
            // устанавливается в значение выбранного пункта
            this.value = ui.item.label;
            // устанавливаем значения скрытого поля
            $("#Demands_id_resto").val(ui.item.id);
            return false;
        }',
    ),
    'htmlOptions' => array(
        'maxlength' => 50,
    ),
);?>
<table class="main_demand_view">
<tr>
    <th width="40%">
        Заказ <span id="d_menu"><a
            href="<?=$this->createUrl('Demands/update', array('id' => $model->id));?>">ред.</a> | <a
            href="javascript:show_card(<?=$model->id?>);">см.</a></span>
    </th>
    <th width="34%" id="th_offered">
        Предложенные заведения <img src="<?=$iconPath.'navigation-270-button.png';?>" alt="" id='off_more_btn' >
    </th>
    <th width="26%">
        Подтвержденные заведения <img src="<?=$iconPath.'navigation-270-button.png';?>" alt="" id='conf_more_btn' >
    </th>
</tr>
<tr>
    <td>
        <table id='order_info'>
            <tr>
                <td class="brown"><?=$model->c_customer?></td>
                <td class="brown"><?=$model->dateEvent;?></td>
            </tr>
            <tr>
                <td class="brown"><?=$model->c_mail?></td>
                <td class="brown"><?=$model->c_phone?></td>
            </tr>
            <? if (!empty($model->t_user_comment)) { ?>
            <tr>
                <td colspan="2" class="brown"><?=$model->t_user_comment?></td>
            </tr>
            <? }?>
            <? if (!empty($model->t_offer_comment)) { ?>
            <tr>
                <td colspan="2" style="color: red">Комментарий клиента: <?=$model->t_offer_comment?></td>
            </tr>
            <? }?>
            <tr>
                <td>Статус</td>
                <td><?php echo CHtml::activeDropDownList($model, 'is_demand_status', $demand_status, array('style' => 'width:200px'));?></td>
            </tr>
            <? $display = (($model->is_demand_status == 5 || $model->is_demand_status == 8) && $model->status) ? ''
                : 'none';?>
            <tr style="display:<?=$display?>" id="tr_restos">
                <td>Заведение</td>
                <td><input id="restos" value="<?=$model->resto?>" type="text" style="width:200px">
                    <?php echo CHtml::activehiddenField($model, 'id_resto', array('style' => 'display: none;')); ?>
                </td>
            </tr>
            <? $display = (($model->is_demand_status == 8) && $model->status) ? '' : 'none';?>
            <tr style="display:<?=$display?>" id="tr_profit">
                <td>Комиссионные</td>
                <td><?php echo CHtml::activeTextField($model, 'f_profit', array('style' => 'width:60px'))?>руб.
                </td>
            </tr>
            <tr style="display:<?=$display?>" id="tr_date_profit">
                <td>Дата получения</td>
                <td><?php echo CHtml::activeTextField($model, 'date_profit', array('style' => 'width:80px'))?></td>
            </tr>
            <? $display2 = (($model->is_demand_status == 6) && $model->status) ? '' : 'none';?>
            <tr class="tr_failure" style="display:<?=$display2?>">
                  <td>Куда ушли</td>
                <td>
                    <?php echo CHtml::activeTextField($model, 'c_failure_resto', array('style'=>'width:190px')); ?>
                </td>

            </tr>
            <tr class="tr_failure" style="display:<?=$display2?>">
                  <td>Причина срыва</td>
                <td>
                    <?php  echo CHtml::activeTextField($model, 'c_failure_reason', array('style'=>'width:190px')); ?>
                </td>

            </tr>
            <? if (Yii::app()->user->CF_STATUS == 1) { ?>
            <tr>
                <td>Менеджер</td>
                <td><?php echo CHtml::activeDropDownList($model, 'id_agent', $agents, array('prompt' => '----------', 'style' => 'width:200px'));?></td>
            </tr>
            <? }?>
            <!--  <tr>
                    <td>Архив</td>
                    <td><input type="checkbox" <? if ($model->status == 0) { ?> checked<? }?> id="Demands_status"></td>
                </tr>-->
            <tr>
                <td colspan="2" id="ch" style="padding-left:120px; padding-top:10px">
                    <table id="agr_btn2">
                        <tr>
                            <td class="agr_btn_left">
                                <div>&nbsp;</div>
                            </td>
                            <td class="agr_btn_bg" id="save_demand_changes">Сохранить изменения</td>
                            <td class="agr_btn_right">
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--  <tr>
                <td>Предложение отправлено в</td>
                <td id="t_send_place" class="brown"></td>
            </tr>
            <tr>
                <td>Предложение просмотрено в</td>
                <td id="t_view_place" class="brown"></td>
            </tr>
            <tr>
                <td>Получено подтверждение в</td>
                <td id="t_confirm_place" class="brown"></td>
            </tr>-->
        </table>
    </td>
    <td id="td_offered">
        <div id="offered_object_place"></div>
    </td>
    <td id="td_conf">
        <div id="confirmed_object_place"></div>
    </td>
</tr>
<tr id='tr_off_objects' style="display: none;">
    <td colspan="3">
        <div class="item_title"></div>
        <div style="width: 100%" id="item_place">

        </div>
    </td>
</tr>
<tr id='tr_conf_objects' style="display: none;">
    <td colspan="3">
        <div class="conf_item_title"></div>
        <div style="width: 100%" id="conf_item_place">

        </div>
    </td>
</tr>
<? if (in_array($model->is_demand_status, array(2, 3, 4, 5, 9)) && $model->status) {
    ?>
<tr id='tr_send_offer'>
    <td>
        <div id="send_offer_btn" style="float:left;">
            <table>
                <tr>
                    <td class="sof_btn_left">
                        <div>&nbsp;</div>
                    </td>
                    <td class="sof_btn_bg">Отправить предложение</td>
                    <td class="sof_btn_right">
                        <div>&nbsp;</div>
                    </td>
                </tr>
            </table>
        </div>
        <?php if ($model->is_demand_status != 2) { ?>
        <div style="float:left; padding-left: 20px; white-space: nowrap;">
            <input type="checkbox" value="1" id='double'> Продублировать в заведения
        </div>
        <? } ?>
    </td>
    <td colspan="2" id="group_place">
        <table>
            <tr>
                <td> Группы
                    заведений: <?php  echo CHtml::dropDownList('is_group', '', $groups, array('prompt' => '----------', 'style' => 'width:140px')); ?>
                </td>
                <td style="padding-left:10px; padding-top:3px">
                    <table id="agr_btn">
                        <tr>
                            <td class="agr_btn_left">
                                <div>&nbsp;</div>
                            </td>
                            <td class="agr_btn_bg">Добавить</td>
                            <td class="agr_btn_right">
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr id='tr_search'>
    <td colspan="3">
        <div id="sear_label">Подбор заведений  <a href='/demands/viewDemand?id_demand=<?=$model->id?>' style="font-size: 11px; margin-left: 30px">сбросить фильтры</a></div>
        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'obj_podbor', 'enableAjaxValidation' => true, 'action' => '/search', 'method' => 'GET')); ?>
        <table id="search_place">
            <tr>
                <td width="50px">
                    <span> <b>Название:</b></span>
                </td>
                <td style="width: 220px">
                    <?php  echo $form->textField($podbor, 'c_name', array('style' => 'width:205px'));?>
                </td>
                <td width="40px">
                    <span> <b>Тип:</b></span>
                </td>
                <td width="240px">
                    <div style="float: left; position: relative; top: -3px" id='typePlaceMulti'>
                        <?php $htmlOptions = array('class' => 'multiselect', 'minWidth' => '220', 'checkAllText' => 'Все',
                                                   'uncheckAllText' => 'Очистить');
                        $multiConfig = array('model' => $podbor, 'attribute' => 'sType', 'data' => $restoTypes, 'htmlOptions' => $htmlOptions);
                        echo $this->widget('application.zii.widgets.jui.MyMultiSelect', $multiConfig, true);
                        ?>
                    </div>
                </td>
                <td width="45px">
                    <span> <b>Район:</b></span>
                </td>
                <td width="230px">
                    <div style="float: left; position: relative; top: -3px">
                        <?php $htmlOptions = array('class' => 'multiselect', 'minWidth' => '220', 'checkAllText' => 'Все',
                                                   'uncheckAllText' => 'Очистить');
                        $multiConfig = array('model' => $podbor, 'attribute' => 's_distr', 'data' => $districts, 'htmlOptions' => $htmlOptions);
                        echo $this->widget('application.zii.widgets.jui.MyMultiSelect', $multiConfig, true);
                        ?>
                    </div>
                <td width="50px">
                    <span> <b>Метро:</b></span>
                </td>
                <td width="230px">
                    <div style="float: left; position: relative; top: -3px" id='metroPlaceMulti'>
                        <?php $htmlOptions = array('class' => 'multiselect', 'minWidth' => '220', 'checkAllText' => 'Все',
                                                   'uncheckAllText' => 'Очистить');
                        $multiConfig = array('model' => $podbor, 'attribute' => 'sMetro', 'data' => $metros, 'htmlOptions' => $htmlOptions);
                        echo $this->widget('application.zii.widgets.jui.MyMultiSelect', $multiConfig, true);
                        ?>
                    </div>
                </td>
            </tr>
            <tr class="sLine">
                <td >
                    <span> <b>Кухня:</b></span>
                </td>
                <td >
                    <div style="float: left; position: relative; top: -3px">
                        <?php $htmlOptions = array('class' => 'multiselect', 'minWidth' => '210', 'checkAllText' => 'Все',
                                                   'uncheckAllText' => 'Очистить');
                        $multiConfig = array('model' => $podbor, 'attribute' => 'sKitchen', 'data' => $kitchens, 'htmlOptions' => $htmlOptions);
                        echo $this->widget('application.zii.widgets.jui.MyMultiSelect', $multiConfig, true);
                        ?>
                    </div>
                </td>
                <td>
                    <span> <b>Счет:</b></span>
                </td>
                <td>
                  <?php  echo $form->textField($podbor, 'b_bill_from', array('class' => 'fr_to'));?>
                        - <?php  echo $form->textField($podbor, 'b_bill_to', array('class' => 'fr_to'));?> руб.
                </td>
                <td>
                  <span> <b>Мест:</b></span>
                </td>
                <td>
                  <?php  echo $form->textField($podbor, 'cnt_pl_f', array('class' => 'fr_to'));?>
                        - <?php  echo $form->textField($podbor, 'cnt_pl_to', array('class' => 'fr_to'));?>
                </td>
                <td nowrap>

                </td>
                <td >
                    <? echo CHtml::Button('Найти', array('id' => 'search_btn', 'style' => 'height:auto; margin-left:40px; cursor:pointer'))?>
                    <? echo CHtml::Button('Добавить', array('id' => 'add_btn', 'style' => 'height:auto; margin-left:20px'))?>
                </td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>
    </td>
</tr>
    <? }?>
</table>
<? if (in_array($model->is_demand_status, array(2, 3, 4, 5, 9)) && $model->status) { ?>
<div id="result_place"></div>
<? } ?>
<div id="galleryPlace" class="modal">

</div>


<?php Yii::app()->clientScript->registerScript('vd', "
        id_demand = " . $model->id . ";
       // $('#SResto_c_name').bind('keyup', function() { if (this.value.length==0 || this.value.length >= 3) podbor_obj();});
       // $('#SResto_b_bill_from').bind('keyup', function() { if (this.value.length==0 || this.value.length >= 3) podbor_obj();});
       // $('#SResto_b_bill_to').bind('keyup', function() { if (this.value.length==0 || this.value.length >= 3) podbor_obj();});
       // $('#SResto_cnt_pl_f').bind('keyup', function() { if (this.value.length==0 || this.value.length >= 2) podbor_obj();});
       // $('#SResto_cnt_pl_to').bind('keyup', function() { if (this.value.length==0 || this.value.length >= 2) podbor_obj();});
        $('#search_btn').bind('click', podbor_obj);
        $('#add_btn').bind('click', add_obj);
        $('#agr_btn').bind('click', add_group_obj);
        $('#save_demand_changes').bind('click', save_demand_changes);
        $('#send_offer_btn').bind('click', send_offer);
        $('#Demands_is_demand_status').bind('change', change_status);
        $('#off_more_btn').bind('click', show_offered_objects_list);
        $('#conf_more_btn').bind('click', show_confirmed_objects_list);
        init_autocomplete();
        get_offered_objects();
        get_confirmed_objects();
        podbor_obj();
        jQuery('#Demands_date_profit').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['ru'], {'dateFormat':'dd-mm-yy'}));
        gpage = 0;
");
 
