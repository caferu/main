<?php
//$model->status=1;
$provider = $model->search();
$provider->setSort(array('defaultOrder'=>'t.status DESC, t.short_name'));
//var_dump($provider);
$provider->setPagination(array('pageSize' => 100));
$this->widget('application.zii.widgets.grid.MyGridView', array(
                                                              'id' => 'food-vendors-grid',
                                                              'dataProvider' => $provider,
                                                             // 'filter' => $model,
                                                              'columns' => array(
                                                            //      array('name' => 'id', 'filter' => false,),
                                                                  array(
                                                                      'name' => 'logo',
                                                                      'value' => 'CHtml::image("http://cafespb.ru/".$data->uploadTo("logo"), $data->name, array("width"=>"60px"))',
                                                                      'type' => 'raw',
                                                                      'filter' => false,
                                                                  ),
                                                                    array(
                                                                      'name' =>'short_name',
                                                                      'headerHtmlOptions' => array('style' => 'width:100px'),
                                                                                    ),
                                                                      array(
                                                                      'name' =>'identity',
                                                                      'headerHtmlOptions' => array('style' => 'width:150px'),
                                                                                    ),
                                                                   array(
                                                                      'name' =>'name',
                                                                      'headerHtmlOptions' => array('style' => 'width:130px'),
                                                                                    ),
                                                                  array(
                                                                      'header' => 'Дополнительно',
                                                                      'value' => '$data->additionalInfo',
                                                                      'type' => 'raw',
                                                                      'htmlOptions' => array('style' => 'min-width:350px')
                                                                  ),
                                                                  array(
                                                                      'name' => 'delivery_price',
                                                                      'headerHtmlOptions' => array('style' => 'width:50px'),
                                                                      'filter' => false,
                                                                  ),
                                                                  array(
                                                                      'name' => 'free_delivery_sum',
                                                                      'headerHtmlOptions' => array('style' => 'width:50px'),
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
                                                                     // 'value'=>'($data->status==1)?1:0',
                                                                      'headerHtmlOptions' => array('style' => 'white-space:nowrap'),
                                                                      'htmlOptions' => array('style' => 'text-align:center; width:30px')
                                                                  ),
                                                                 array(
                                                                      'class' => 'CButtonColumn',
                                                                      'template' => "{update}{delete}{timing}",
                                                                      'buttons' => array(
                                                                          'timing' => array(
                                                                              'label' => 'Тайминг',
                                                                              'url' => 'Yii::app()->controller->createUrl("timing",array("id"=>$data->id))',
                                                                              'imageUrl' => Yii::app()->request->baseUrl . '/images/clock--pencil.png',
                                                                              'options' => array('style' => 'padding-left:3px;'),
                                                                        ),
                                                                      ),
                                                                      'htmlOptions' => array('style' => 'white-space: nowrap'),
                                                                  ),
                                                              ),
                                                         ));
