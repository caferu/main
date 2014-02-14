<?php
$this->breadcrumbs=array(
'Настройки',
);
?>
<div id="form_div" class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'object-resto-form',
    'enableAjaxValidation' => false,
));
?>
<?php echo $form->errorSummary($model); ?>
 <table class="add_form_table2" >
                        <tr>
                            <td><?php echo $form->labelEx($model, 'i_demands_in_list'); ?></td>
                            <td><?php echo $form->textField($model, 'i_demands_in_list', array('size' => '2'));?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'i_obj_in_podbor'); ?></td>
                            <td><?php echo $form->dropDownList($model, 'i_obj_in_podbor', array(12=>12,16=>16,20=>20,24=>24,28=>28,32=>32,36=>36,40=>40,44=>44,48=>48,52=>52,56=>56,60=>60));?></td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $form->labelEx($model, 'b_new_window'); ?></td>
                            <td><?php echo $form->checkBox($model, 'b_new_window'); ?></td>
                        </tr>
     </table>
        <div class="row buttons" style="text-align:center;">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>
<?php $this->endWidget(); ?>
 </div>