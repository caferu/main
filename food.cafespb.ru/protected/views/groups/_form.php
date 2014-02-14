<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'group-form',
    'enableAjaxValidation' => false,
));
?>
<div id="group_div">
    Название
    группы: <?php echo $form->textField($model, 'c_name'); ?> <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
<? if (Yii::app()->user->CF_STATUS != 3) {
    echo $form->checkBox($model, 'b_public'); ?>публичная<?
}
echo $form->hiddenField($model, 'id');?>
    <input type="hidden" value="<?=$model->isNewRecord?>" id="act">
<?php $this->endWidget(); ?>
    <script type="text/javascript">

        $(document).ready(function() {
            $('#group-form').bind('submit', save_group);
        })
    </script>
</div>