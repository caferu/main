<?php
 Yii::app()->clientScript->registerScript('date',"
$('#BusyDates_busy_date').datepicker($.extend({showMonthAfterYear:false}, $.datepicker.regional['ru'], {'dateFormat':'dd-mm-yy'}));
");?>
<div style="width:100%">
    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'busy-date-form',
                                                         'enableAjaxValidation' => false,
                                                    ));
    ?>
                <table id='busy_dates_tbl' style="width: 700px">
                    <tr>
                        <th>Дата</th>
                        <th>Степень занятости</th>
                        <th>Комментарий</th>
                         <td></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model_date, 'busy_date', array('size' => 10)); ?>
                        </td>
                        <td><?php echo $form->dropDownList($model_date, 'is_busy_date_type', CHtml::listData(DictBusyDateType::model()->findAll('status=1'), 'id', 'c_name'));?>
                        </td>
                        <td>
                            <?php echo $form->textField($model_date, 't_comment', array('size' => 60)); ?>
                        </td>
                      <td>
                            <?php echo $form->hiddenField($model_date, 'id_object');?>
                            <input type="image" src="/images/plus-button.png" alt="Добавить">
                        </td>
                    </tr><?php
if (!empty($busy_dates)) {
                    ?>

                    <?php

                    foreach ($busy_dates as $v) { ?>
                        <tr id='busy_dates_tr'>
                            <td width="100px"><?=date('d.m.Y', strtotime($v->busy_date))?></td>
                            <td width="120px"><?=$v->type->c_name?></td>
                            <td><?=$v->t_comment?></td>
                            <td width="20px" >

                                <a href="<?=$this->createUrl('deleteBusyDate', array('idDate'=>$v->id));?>">
                                    <img src="/images/del.png" alt="" style="cursor: pointer;">
                                </a>

                                                  </td>
                        </tr>
                        <? }
                }?>

                </table>
        <? $this->endWidget(); ?>
</div>

 
