<div style="width:980px">
    <h1><?=$model->c_name?></h1>
    <?php

    $form = $this->beginWidget('CActiveForm', array(
                                                   'id' => 'objectResto-form',
                                                   'enableAjaxValidation' => false,
                                              ));
    echo $form->errorSummary($model);
    ?>
    <table style="width: 100%">
        <tr>
            <td width="50%">
                <table style="margin-top:10px; width:100%">
                    <tr class="row1">
                        <td width="50%">
                            Залы:
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'planning'); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'i_bill'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'i_bill', array('size' => 3)); ?> руб.
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_gardin'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_gardin'); ?>
                            <span style="margin-left: 10px"><?php echo $form->textField($model, 'c_gardin', array('size' => 20, 'maxlength' => 50)); ?></span>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_director_name'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_director_name', array('size' => 25, 'maxlength' => 100)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_banket_admin'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_banket_admin', array('size' => 25, 'maxlength' => 100)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_phone'); ?></td>
                        <td><?php echo $form->textField($model, 'c_phone', array('size' => 25, 'maxlength' => 100)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'i_banket_bill'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'i_banket_bill', array('size'=>3)); ?> руб.
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'i_banket_bill_hot'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'i_banket_bill_hot', array('size' => 3)); ?> руб.
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_info_mail'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_info_mail', array('size' => 25, 'maxlength' => 100)); ?>
                            <?php echo $form->error($model, 'c_info_mail'); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_sms'); ?>
                            <div style="font-size: 11px;">(xxx) xxx-xx-xx</div>
                        </td>
                        <td>+7 <?php echo $form->textField($model, 'c_sms'); ?>
                            <?php echo $form->error($model, 'c_sms', array('size'=>12)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_site_resto'); ?>
                        </td>
                        <td>http://www.<?php echo $form->textField($model, 'c_site_resto', array('size'=>15)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_contact_info'); ?>
                        </td>
                        <td><?php echo $form->textArea($model, 'c_contact_info', array('cols' => 25, 'rows'=>2)); ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                     <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_order_info'); ?>
                        </td>
                        <td><?php echo $form->textArea($model, 'c_order_info', array('cols' => 25, 'rows'=>2)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td nowrap><?php echo $form->labelEx($model, 'ReceiveOrderType'); ?>
                        </td>
                        <td>
                            <div style="position: relative">
                                <?php echo $form->listBox($model, 'ReceiveOrderType', CHtml::listData(DictReceiveOrderType::model()->findAll(), 'id', 'c_name'), array('class' => 'chosenmultiselect',
                     'multiple' => true,
                     'style' => 'width:250px',
                     'data-placeholder' => 'Выберите из списка...',)); ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_service'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_service', array('size' => 25)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_arenda'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_arenda', array('size' => 25)); ?>
                        </td>
                    </tr>

                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_alko'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_alko', array('size' => 25)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_client_bonus'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_client_bonus', array('size' => 25)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'c_equipment'); ?>
                        </td>
                        <td><?php echo $form->textField($model, 'c_equipment', array('size' => 25)); ?>
                        </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_music_night'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_music_night'); ?> </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_gala_cover'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_gala_cover'); ?> </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_child_room'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_child_room'); ?> </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_child_menu'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_child_menu'); ?> </td>
                    </tr>
                    <tr class="row1">
                        <td><?php echo $form->labelEx($model, 'b_karaoke'); ?>
                        </td>
                        <td><?php echo $form->checkBox($model, 'b_karaoke'); ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="row1" style="text-align:center;">
    <?php
                                    echo $form->hiddenField($model, 'id');
        echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>
<script type="text/javascript">

    //$(document).ready(function() {
    $('#objectResto-form').bind('submit', save_resto);
    // })
</script>
