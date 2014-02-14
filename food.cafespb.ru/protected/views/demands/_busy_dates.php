<div style="width:100%">
    <h1><?=$model->c_name?></h1>
    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'busy-date-form',
                                                         'enableAjaxValidation' => false,
                                                    ));
    ?>
    <table style="100%; margin-top: 10px">
        <tr>
            <td>
                <table id='busy_dates_tbl'>
                    <tr>
                        <td>Дата</td>
                        <td>Степень занятости</td>
                        <td>Комментарий</td>
                        <td>Пользователь</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model_date, 'busy_date', array('size' => 10)); ?>
                        </td>
                        <td><?php echo $form->dropDownList($model_date, 'is_busy_date_type', CHtml::listData(DictBusyDateType::model()->findAll('status=1'), 'id', 'c_name'));?>
                        </td>
                        <td>
                            <?php echo $form->textField($model_date, 't_comment', array('size' => 32)); ?>
                        </td>
                        <td></td>
                        <td>
                            <?php echo $form->hiddenField($model_date, 'id_object');?>
                            <img src="/images/plus-button.png" alt="Добавить" id='add_busy_date_btn'>
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
                            <td width="120px"><? $agent = (empty($v->id_user))?'заведение':$v->Agent->c_name; echo $agent;?></td>
                            <td width="20px" >
                              <?
                        if (Yii::app()->user->CF_STATUS == 1 || $user == $v['id_user']){?>
                                <img class="bd_del_button" src="/images/del.png" alt="" style="cursor: pointer"
                                                  onclick="delete_busy_date(<?=$v['id']?>)">
                            <?}?>
                                                  </td>
                        </tr>
                        <? }
                }?>

                </table>
</div>
<? $this->endWidget(); ?>
 
