<?php

$form = $this->beginWidget('MyActiveForm');

echo $form->beginForm();
echo $form->errorSummary($model);

echo $form->beginField();
echo $form->renderField($model, 'foodVendor');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'category');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'name');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'price');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'picture');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'description');
echo $form->endField();

echo $form->beginField();
echo $form->renderField($model, 'status');
echo $form->endField();

echo $form->buttons($model);
echo $form->endForm();

$this->endWidget();
