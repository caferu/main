<div class='flash'>
     <p><b>Для обновления данных загрузите xml-файлы. Возможена загрузка нескольких файлов. После загрузки обновите стреницу, чтобы увидеть изменения. </b></p>
<?php
$config = array('action' => 'upload',
                'allowedExtensions' => array("xml"),
   // 'onComplete'=>"js:function(){ location.reload(); }",
                'multiple' => true);

$params = array('id'=>'uploadFile','config' => $config);

$this->widget('application.extensions.EAjaxUpload.EAjaxUpload', $params);
?>
     </div>
     <?php
$provider = $model->search();
$provider->setPagination(array('pageSize' => 50));


$this->widget('application.zii.widgets.grid.MyGridView', array(
                                                              'id' => 'food-offers-grid',
                                                              'dataProvider' => $provider,
                                                              'filter' => $model,
                                                              'columns' => array(
                                                                  array('name' => 'id', 'filter' => false,),
                                                                  array(
                                                                      'name' => 'picture',
                                                                      'value' => 'CHtml::image($data->picture, $data->name, array("width"=>"80px"))',
                                                                      'type' => 'raw',
                                                                      'filter' => false,
                                                                  ),
                                                                  'name',
                                                                  array(
                                                                      'name' => 'vendor_id',
                                                                      'filter' => CHtml::listData(FoodVendors::model()->active()->findAll(), 'id', 'name'),
                                                                      'value' => '$data->foodVendor'
                                                                  ),
                                                                  array(
                                                                      'name' => 'category_id',
                                                                      // 'filter' => CHtml::listData(FoodCategories::model()->active()->findAll(), 'id', 'name'),
                                                                      'htmlOptions' => array('style' => 'white-space:nowrap'),
                                                                      'filter' => false,
                                                                      'value' => '$data->category'
                                                                  ),
                                                                  array(
                                                                  'name' => 'price',
                                                                      'filter' => false,
                                                                  ),
                                                                  array(
                                                                      'name' => 'description',
                                                                      'type' => 'html',
                                                                      'filter' => false,
                                                                  ),
                                                                  array(
                                                                      'class' => 'MyBooleanColumn', // 'MyCheckBoxColumn'
                                                                      'name' => 'status',
                                                                      'filter' => false,
                                                                      //'checked' => '$data->main_page',
                                                                      // 'value'=>'$data->id',
                                                                      'headerHtmlOptions' => array('style' => 'white-space:nowrap'),
                                                                      'htmlOptions' => array('style' => 'text-align:center; width:30px')
                                                                  ),

                                                                  array(
                                                                      'class' => 'MyButtonColumn',
                                                                  ),
                                                              ),
                                                         ));
