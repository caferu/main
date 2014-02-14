<?php
$this->breadcrumbs = array(
    'Заказы',
);?>
<?php 
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('reports', "
    $(document).ready(function(){
      control_url = '" . Yii::app()->createUrl('demands') . "/';
      base_url = '" . Yii::app()->request->baseUrl . "';
    });");
$columns = array(array(
                     'header' => '№',
                     'name' => 'id',
                     'htmlOptions' => array('width' => '30px')
                 ),
                    array(
                     'header' => 'Дата',
                     'value' => 'date("d.m.y H:i", strtotime($data->created_at))',
                     'htmlOptions' => array('width' => '80px')
                 ),
                 array(
                     'header' => 'Клиент',
                     'name' => 'client_name',
                     'htmlOptions' => array('style' => 'width:100px;')
                 ),
                 array(
                     'header' => 'Телефон',
                     'name'=>'client_phone',
                     'htmlOptions' => array('style' => 'width:100px;')
                 ),
                  array(
                     'header' => 'Комментарий',
                     'value' => '$data->comment',
                     'htmlOptions' => array('style' => 'width:150px'),
                 ),
                array(
                     'header' => 'Сумма заказа (руб.)',
                     'value' => '$data->price',
                     'htmlOptions' => array('style' => 'width:50px'),
                 ),
                array(
                     'header' => 'Заказ',
                     'value' => '"<div id=\'order_text\'>". $data->order_text."</div>"',
                     'htmlOptions' => array('style' => 'width:450px'),
                     'type'=>'raw'
                 ),
                 array(
                     'header' => 'Статус',
                     'name' => 'food_demand_status_id',
                     'value' => '$data->demandStatus',
                     'filter' => CHtml::listData(FoodDemandStatuses::model()->findAll('status=1'), 'id', 'name'),
                     'htmlOptions' => array('style' => 'width:50px'),
                 ),
                 array(
                     'header' => 'Комментарий Fasteda.ru',
                     'value' => '$data->manager_comment',
                     'htmlOptions' => array('style' => 'width:150px'),
                 ),


);
$this->widget('application.zii.widgets.grid.DefaultGridView', array(
                                                                        'id' => 'object-resto-grid',
                                                                        'dataProvider' => $model->search(),
                                                                        'formatter' => new Formatter,
                                                                        'filter' => $model,
                                                                        'pager' => $pager,
                                                                         'selectionChanged' => 'change_demand_grid',
                                                                        'template' => "{pager}\n{items}\n{summary}\n",
                                                                        'columns' => $columns));

