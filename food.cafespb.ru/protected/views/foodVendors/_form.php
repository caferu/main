<?php
Yii::app()->clientScript->registerScriptFile('/js/jquery.chosen.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/chosen.css');
Yii::app()->clientScript->registerScript('main', "
$('.chosenmultiselect').chosen();
");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.autotabs.js');
Yii::app()->clientScript->registerScript('autotabs', "$('div.form').fieldsetTabs();");

$form = $this->beginWidget('MyActiveForm', array('files' => true));

echo $form->beginForm();
echo $form->errorSummary($model);
?>
<fieldset>
    <legend>Основные параметры</legend>
<?php

    echo $form->beginField();
    echo $form->renderField($model, 'identity');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'name');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'short_name');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'types');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'kitchens');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'description');
//$config = array('model' => $model, 'attribute' => 'description', 'language' => 'ru',);
//$this->widget('application.extensions.ckeditor.CKEditor', $config);
    echo $form->endField();

    echo $form->beginField();
    echo $form->myFileField($model, 'logo');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'status');
    echo $form->endField();
    ?>
</fieldset>
<fieldset>
    <legend>Доставка</legend>
<?php
echo $form->beginField();

    $sql = "SELECT DISTINCT b.id, b.c_name FROM cf_address_relation a, cf_dict_district b
                WHERE a.is_district=b.id AND a.is_region=78  ORDER BY b.c_name";

    $command = Yii::app()->db->createCommand($sql);
    $districts = $command->queryAll();
//d($districts);
    echo $form->labelEx($model, 'districts');   ?>
    <div style="height: 200px; overflow-y: auto; padding: 10px; width: 300px">
<?php

    $data = array();
    if (!empty($model->districts)) {
        foreach ($model->districts as $v) $data[] = $v->id;
    }
    echo CHtml::checkBoxList('FoodVendors[districts]', $data, CHtml::listData($districts, 'id', 'c_name'));
    ?>
    </div>
    <?php  echo $form->endField();

    echo $form->beginField();
    echo $form->labelEx($model, 'metro');   ?>
    <div style="height: 200px; overflow-y: auto; padding: 10px; width: 300px">
<?php

    $data = array();
    if (!empty($model->metro)) {
        foreach ($model->metro as $v) $data[] = $v->id;
    }
    echo CHtml::checkBoxList('FoodVendors[metro]', $data, CHtml::listData(DictA6n::model()->spb()->findAll(), 'id', 'c_name'));
    ?>
    </div>
    <?php echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'delivery_price');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'free_delivery_sum');
    echo $form->endField();

    echo $form->beginField();
    echo $form->renderField($model, 'delivery_time');
    echo $form->endField();
    ?>
</fieldset>

<?php
echo $form->buttons($model);
echo $form->endForm();

$this->endWidget();
