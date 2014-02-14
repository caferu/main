<? //var_dump($this->demand->attributes);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.simplemodal.js');
$model = $this->demand;
$objStr = ($model->is_demand_status == 3 || $model->is_demand_status == 4) ? 'get_offered_objects2();' : '';
Yii::app()->clientScript->registerScript('reports', "
    $(document).ready(function(){
     id_demand = " . $model->id . ";
      control_url = '" . Yii::app()->createUrl('demands') . "/';
      base_url = '" . Yii::app()->request->baseUrl . "';
      get_confirmed_objects2();
      " . $objStr . "
      $('.gift').bind('click', checkGiftClick);
      $('#confirm_offer').bind('click',function(){ $('#object-resto-form').submit();});
      $('#deny_offer').bind('click',deny_offer);
    });");
$form = $this->beginWidget('CActiveForm', array(
                                               'id' => 'object-resto-form',
                                               'enableAjaxValidation' => false,
                                          ));
?>
<div style="color:#515151">
    <table class='demand_info_tbl'>
        <tr>
            <td width="250px">
                <table width="100%">
                    <tr>
                        <td class="cl_left">
                            <div>&nbsp;</div>
                        </td>
                        <td class="cl_bg">Ваш заказ</td>
                        <td class="cl_right">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="clb_bg2">
                            <table class="cl_paran_tbl">
                                <tr>
                                    <td width="60%">Дата</td>
                                    <td class="b_brown"><?=$model->dateEvent; ?></td>
                                </tr>
                                <tr>
                                    <td>Тип мероприятия</td>
                                    <td class="b_brown"><?=$model->BanketType->c_name?></td>
                                </tr>
                                <tr>
                                    <td>Количество человек</td>
                                    <td class="b_brown"><?=$model->i_person?></td>
                                </tr>
                                <tr>
                                    <td>Сумма на человека</td>
                                    <td class="b_brown"><? if (!empty($model->i_sum_person)) echo $model->i_sum_person . ' руб.';?></td>
                                </tr>
                                <tr>
                                    <td>Тип оплаты</td>
                                    <td class="b_brown"><?=$model->KindPay->c_name?></td>
                                </tr>
                                <tr>
                                    <td>Закрытие площадки</td>
                                    <td class="b_brown"><?=Yii::app()->format->boolean($model->b_close);?></td>
                                </tr>
                                <tr>
                                    <td>Свой алкоголь</td>
                                    <td class="b_brown"><?=Yii::app()->format->boolean($model->b_alko);?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="clb_left">
                            <div>&nbsp;</div>
                        </td>
                        <td class="clb_bg">&nbsp;</td>
                        <td class="clb_right">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="padding-left:10px; padding-right:10px; font-size:12px; font-family:Tahoma">
                <? if ($model->is_demand_status == 3 || $model->is_demand_status == 4) { ?>
                <!-- <div style="width:100%">Обращаем Ваше внимание, что выбрав заведение из предложенных нами Вы можете
                    бесплатно получить от нашей компании подарок, для этого выберите
                    один из предложенных ниже:
                </div>-->
                <!-- <table style="margin-top:10px">
                    <tr>
                        <td style="padding-right:10px">
                            <table id='adp_table' style="width:85px">
                                <tr>
                                    <td class="adp_left" >
                                        <div>&nbsp;</div>
                                    </td>
                                    <td class="adp_bg" style="padding-left:0px">
                                    <?php /*echo CHtml::checkBox('is_gift','',array('style'=>'left:0px', 'value'=>1, 'class'=>'gift', 'id'=>'gift1')); */?> Каравай
                                    </td>
                                    <td class="adp_right">
                                        <div>&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                         <td style="padding-right:10px">
                            <table id='adp_table' style="width:130px">
                                <tr>
                                    <td class="adp_left">
                                        <div>&nbsp;</div>
                                    </td>
                                    <td class="adp_bg" style="padding-left:0px">
                                    <?php /*echo CHtml::checkBox('is_gift','',array('style'=>'left:0px', 'value'=>2, 'class'=>'gift', 'id'=>'gift2')); */?> Свадебный торт
                                    </td>
                                    <td class="adp_right">
                                        <div>&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table id='adp_table' style="width:220px">
                                <tr>
                                    <td class="adp_left">
                                        <div>&nbsp;</div>
                                    </td>
                                    <td class="adp_bg" style="padding-left:0px">
                                   <?php /*echo CHtml::checkBox('is_gift','',array('style'=>'left:0px', 'value'=>3, 'class'=>'gift', 'id'=>'gift3')); */?>Абонемент в солярий (50 мин.)
                                    </td>
                                    <td class="adp_right">
                                        <div>&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                         --><? /* echo $form->hiddenField($model,'is_gift');*/ ?>
                <div style="width:100%; padding-top:5px">Чтобы мы понимали какое заведение могло бы Вас заинтересовать,
                    оцените заведения
                    кнопками <span class="b_brown">выбрать/отклонить</span>, выбранные Вами отобразятся в колонке
                    справа.
                </div>
                <div style="font-weight:bold; text-align:right; padding:5px; font-size:11px">Ваш комментарий</div>
                <div>
                    <?php echo $form->textArea($model, 't_offer_comment', array('style' => 'width:100%; height:60px')); ?>
                </div>
                <div style="text-align: center; padding-top: 5px"><input type="button" value="Отправить"
                                                                         id="confirm_offer"
                                                                         style="background-color: #EFEFEF;">
                </div>
                <?
            }
            else if ($model->is_demand_status == 9) {
                ?>
                <div style="width:100%; padding-top:5px; text-align:center;">
                    Спасибо. <br> В ближайшее время мы подготовим для Вас новую подборку заведений.
                </div>
                <? } else { ?>
                <div style="width:100%; padding-top:5px; text-align:center;">Спасибо за то, что воспользовались нашим
                    сервисом.
                    <p>
                        Телефон банкетной службы: 244-25-80
                    </p>
                </div>
                <? }?>


            </td>
            <td width="250px">
                <table width="100%">
                    <tr>
                        <td class="cl_left">
                            <div>&nbsp;</div>
                        </td>
                        <td class="cl_bg">Выбранные заведения</td>
                        <td class="cl_right">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="clb_bg2" id="confirmed_object_place">

                        </td>
                    </tr>
                    <tr>
                        <td class="clb_left">
                            <div>&nbsp;</div>
                        </td>
                        <td class="clb_bg">&nbsp;</td>
                        <td class="clb_right">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div id="objects_place">

    </div>
    <div id="galleryPlace" class="modal">

</div>
</div>
<?php $this->endWidget(); ?>
