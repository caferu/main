<?php
$this->breadcrumbs=array(
'Личные данные',
);
?>
<div id="form_div" class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'object-resto-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<?php echo $form->errorSummary($model); ?>
 <table class="add_form_table2" >
                         <tr>
                            <td><?php echo $form->labelEx($model, 'c_name'); ?></td>
                            <td><?php echo $form->textField($model, 'c_name', array('size' => '30'));?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'c_photo'); ?>
                            <div class='staff_photo'>
                               <?php if(!empty($model->c_photo)){?><img src="/imgupload/staff/<?=$model->c_photo?>" alt=""><?}?>
                            </div>
                            </td>
                            <td><?php echo CHtml::fileField('file', '', array('size' => 20)); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'c_email'); ?></td>
                            <td><?php echo $form->textField($model, 'c_email', array('size' => '30'));?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'c_phone'); ?></td>
                            <td><?php echo $form->textField($model, 'c_phone', array('size' => '60'));?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'c_work_phone'); ?></td>
                            <td><?php echo $form->textField($model, 'c_work_phone', array('size' => '60'));?></td>
                        </tr>
     <tr>
                            <td><?php echo $form->labelEx($model, 'c_sms'); ?>
                            <div style="font-size: 11px;">(xxx) xxx-xx-xx</div></td>
                            <td>+7 <?php echo $form->textField($model, 'c_sms', array('size' => '15'));?></td>
                        </tr>

     </table>
        <div class="row buttons" style="text-align:center;">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>
<?php $this->endWidget(); ?>
 </div>

