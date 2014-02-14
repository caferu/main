<?php
$this->breadcrumbs=array(
'Личные данные',
);
?>
<a href='<?=$this->createUrl('site/editUser');?>' class="redlink" style="position:relative; top:-28px">Редактировать</a>
<div id="form_div" class="form">
 <table class="add_form_table2" >
                         <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_name'); ?></td>
                            <td><?php echo $model->c_name?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_photo'); ?></td>
                            <td><?php if(!empty($model->c_photo)){?><img src="/imgupload/staff/<?=$model->c_photo?>" alt=""><?}?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_email'); ?></td>
                            <td><?php echo $model->c_email?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_phone'); ?></td>
                            <td><?php echo $model->c_phone?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_work_phone'); ?></td>
                            <td><?php echo $model->c_work_phone?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($model, 'c_sms'); ?></td>
                            <td>+7 <?php echo $model->c_sms;?></td>
                        </tr>

     </table>
 </div>
 
