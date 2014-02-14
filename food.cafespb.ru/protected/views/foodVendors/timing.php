<?
$this->widget('application.extensions.EColorBox.EColorBox', array(
                                                                 'target' => '.colorBox',
                                                            ));
if ($this->hasFlash('default')) { ?>
        <div class="flash">
        <?php echo $this->getFlash('default'); ?>
    </div>
        <?php } ?>
<fieldset>
    <legend>Условия
        доставки <?php echo CHtml::link(CHtml::image('/images/plus-button.png', ''), array('foodVendors/addCondition', 'id' => $model->id), array('style' => 'position:relative; left:5px; top:3px', 'class' => 'colorBox')); ?></legend>
    <?php if (!empty($model->conditions)) { ?>
    <table style="width: 600px" id='busy_dates_tbl'>
        <?php
         foreach ($model->conditions as $v) {
        echo '<tr><td width="90%">' . CHtml::link($v->description, array('foodVendors/editCondition', 'id' => $v->id), array('class' => 'colorBox')) . '</td><td>' . CHtml::link('-', array('foodVendors/deleteCondition', 'id' => $v->id)) . '</td></tr>';
    }
        ?>
    </table>
    <?php } ?>
</fieldset>
<fieldset>
    <legend>По районам </legend>
    <?php if (!empty($model->cDistricts)) {
    $form = $this->beginWidget('MyActiveForm', array('files' => true));
    echo $form->beginForm();?>
    <table style="width: 600px" id='busy_dates_tbl'>
        <?php
         foreach ($model->cDistricts as $v) {
        echo '<tr><td>'.$v->district->c_name.'</td><td width="70%">' . CHtml::dropDownList('foodVendorsDistricts['.$v->district_id.']', $v->condition_id, CHtml::listData($model->conditions,'id','description'), array('prompt'=>'---')). '</td></tr>';
    }
        ?>
    </table>
        <div class="row" style="width: 400px">
        <input type="submit" value="Сохранить" name="yt0" class="btn primary">
    </div>
    <?php
echo $form->endForm();

$this->endWidget();}
    ?>
</fieldset>
 
