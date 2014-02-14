<table class="main_demand_view">
    <tr>
        <th width="40%">
            Заведения в группе <? if ($model->editable){?>
    <span id="dgroup_icon">
        <a href="javascript:edit_group(<?=$model->id?>);">ред.</a> |
        <a href="javascript:del_group(<?=$model->id?>);">уд.</a>
   </span>
        <?}?>
        </th>
    </tr>
    <tr>
        <td id="td_offered">
            <div id="offered_object_place"></div>
        </td>
    </tr>

    <? if ($model->editable){?>
    <tr id='tr_search'>
        <td >
            <div id="sear_label">Подбор заведений</div>
        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'obj_podbor', 'enableAjaxValidation' => true, 'action' => '/search', 'method' => 'GET')); ?>
            <table id="search_place">
                <tr>
                    <td>
                        Название <?php  echo $form->textField($podbor, 'c_name', array('style' => 'width:110px'));?></td>
                    <td><?php  echo $form->dropDownList($podbor, 'is_district', CHtml::listData($districts, 'id', 'c_name'), array('multiple' => 'multiple', 'style' => 'width:140px')); ?></td>
                    <td> <?php  echo $form->dropDownList($podbor, 'is_a6n', CHtml::listData(DictA6n::model()->spb()->findAll(), 'id', 'c_name'), array('multiple' => 'multiple', 'style' => 'width:140px')); ?></td>
                    <td> Счет <?php  echo $form->textField($podbor, 'b_bill_from', array('class' => 'fr_to'));?>
                        - <?php  echo $form->textField($podbor, 'b_bill_to', array('class' => 'fr_to'));?> руб.
                    </td>
                    <td> Мест <?php  echo $form->textField($podbor, 'cnt_pl_f', array('class' => 'fr_to'));?>
                        - <?php  echo $form->textField($podbor, 'cnt_pl_to', array('class' => 'fr_to'));?></td>
                    <td>
                    <? echo CHtml::Button('Найти', array('id' => 'podbor_btn', 'style' => 'height:auto'))?></td>
                    <td><? echo CHtml::Button('Добавить', array('id' => 'add_btn', 'style' => 'height:auto'))?></td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </td>
    </tr>
        <?}?>
</table>
    <? if ($model->editable){?>
<div id="result_place"></div>
        <?}?>

 
