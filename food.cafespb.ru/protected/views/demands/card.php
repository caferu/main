<table class="add_form_table" style="width: 850px">
            <tr>
                <th width="50%">Мероприятие</th>
                <th>Клиент</th>
            </tr>
            <tr>
                <td style="border-right:solid 1px #efefef; ">
                    <table class="add_form_table2" >
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'is_banket_type'); ?></td>
                            <td class="brown"><?=$model->BanketType->c_name?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'date'); ?></td>
                            <td class="brown"><?=$model->dateEvent; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_time'); ?></td>
                            <td class="brown"><?=$model->c_time?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'i_person'); ?></td>
                            <td class="brown"><?=$model->i_person?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'i_sum_person'); ?></td>
                            <td class="brown"><? if (!empty($model->i_sum_person)) echo $model->i_sum_person.' руб.';?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'is_kind_pay'); ?></td>
                            <td class="brown"><?=$model->KindPay->c_name?></td>
                        </tr>
                       <? if (Yii::app()->user->CF_STATUS != 3){?>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'is_demand_source'); ?></td>
                            <td class="brown"><?=$model->DemandSource->c_name;?></td>
                        </tr>
                        <?}?>
                        <tr>
                            <td colspan="2">
                                <table id='adp_table'>
                                    <tr>
                                        <td class="adp_left">
                                            <div>&nbsp;</div>
                                        </td>
                                        <td class="adp_bg" style="font-size:11px; padding-top:6px">

                                        <?php echo CHtml::activeLabel($model, 'b_alko'); ?> - <?=Yii::app()->format->boolean($model->b_alko);?>


                                        <?php echo CHtml::activeLabel($model, 'b_close', array('style'=>'margin-left:20px')); ?> - <?=Yii::app()->format->boolean($model->b_close);?>

                                        </td>
                                        <td class="adp_right">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
                <td class="add_form_table_td">
                    <table class="add_form_table2">
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_customer'); ?></td>
                            <td class="brown"><?=$model->c_customer?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_phone'); ?></td>
                            <td class="brown"><?=$model->c_phone?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_mail'); ?></td>
                            <td class="brown"><?=$model->c_mail?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'is_customer_type'); ?></td>
                            <td class="brown"><?=$model->CustomerType->c_name?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_call_time'); ?></td>
                            <td class="brown"><?=$model->c_call_time?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                <?php echo CHtml::activeLabel($model, 't_comment'); ?>:
                 <div style='margin-top:5px;' class="brown">
                    <?=$model->t_comment?>
                </div>
                </td>
                <td>
                <?php echo CHtml::activeLabel($model, 't_user_comment'); ?>:
                <div style='margin-top:5px;' class="brown">
                    <?=$model->t_user_comment?>
                </div>
                </td>
            </tr>
        </table>

