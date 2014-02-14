<?php
    $form = $this->beginWidget('MyActiveForm', array('files' => true));

echo $form->beginForm();
echo $form->errorSummary($model);
echo $form->hiddenField($model, 'vendor_id');
 ?>
<div style="width: 450px;">
    Описание условия:
<?php
    echo $form->textArea($model, 'description', array('style' => 'width:400px'));
    ?>
    <div class="row" style="width: 400px">
        <input type="submit" value="Создать" name="yt0" class="btn primary">
    </div>
<?php
    echo $form->endForm();?>
</div>
<?php $this->endWidget();
?>

 
