<?php
$autocompleteConfig = array(
    'model' => $model_date, // модель
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
            $("#BusyDates_id_object").val(ui.item.id);
            return false;
        }',
    ),
    'htmlOptions' => array(
        'maxlength' => 50,
        'size' =>40
    ),
);
Yii::app()->clientScript->registerScript('date',"
$('#BusyDates_busy_date').datepicker($.extend({showMonthAfterYear:false}, $.datepicker.regional['ru'], {'dateFormat':'dd-mm-yy'}));
");?>
<div style="width:100%">
    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'busy-date-form',
                                                         'enableAjaxValidation' => false,
                                                    ));
    ?>
                <table id='busy_dates_tbl' style="width: 100%">
                    <tr>
                        <th>Дата</th>
                        <th>Степень занятости</th>
                        <th>Комментарий</th>
                        <th>Заведение</th>
                        <th>Пользователь</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model_date, 'busy_date', array('size' => 10)); ?>
                        </td>
                        <td><?php echo $form->dropDownList($model_date, 'is_busy_date_type', CHtml::listData(DictBusyDateType::model()->findAll('status=1'), 'id', 'c_name'));?>
                        </td>
                        <td>
                            <?php echo $form->textField($model_date, 't_comment', array('size' => 40)); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('application.zii.widgets.jui.MyJuiAutoComplete', $autocompleteConfig);
                            echo $form->hiddenField($model_date, 'id_object');?>
                        </td>
                        <td>

                        </td>
                      <td>

                            <input type="image" src="/images/plus-button.png" alt="Добавить">
                        </td>
                    </tr><?php
if (!empty($busy_dates)) {
                    ?>

                    <?php
                     $user = Yii::app()->user->getState('id_user');
                    foreach ($busy_dates as $v) { ?>
                        <tr id='busy_dates_tr'>
                            <td width="100px"><?=date('d.m.Y', strtotime($v->busy_date))?></td>
                            <td width="120px"><?=$v->type->c_name?></td>
                            <td><?=$v->t_comment?></td>
                            <td style="white-space: nowrap"><b><?=$v->objectResto->c_name?></b> <i><?=$v->objectResto->addr?></i></td>
                            <td ><? $agent = (empty($v->id_user))?'заведение':$v->Agent->c_name; echo $agent;?></td>
                            <td width="20px" >
                              <?php if (Yii::app()->user->CF_STATUS == 1 || $user == $v['id_user']){?>
                                <a href="<?=$this->createUrl('delete', array('id'=>$v->id));?>">
                                    <img src="/images/del.png" alt="" style="cursor: pointer;">
                                </a>
                            <?php }?>

                                                  </td>
                        </tr>
                        <? }
                }?>

                </table>
        <? $this->endWidget(); ?>
</div>

 
