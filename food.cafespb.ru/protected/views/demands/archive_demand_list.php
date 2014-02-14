<?php
//Yii::app()->cache->flush();
$dependency = new CDbCacheDependency('SELECT MAX(updated_at) FROM cf_users');
if (Yii::app()->user->CF_STATUS != 1) {
    $main_column_agent = Yii::app()->cache->get('archive_column_agent');
    if ($main_column_agent === false) {
        $main_column_agent = array(array(
                                       'header' => '№ / Дата',
                                       'name' => 'id',
                                       'value' => '$data->id." / ".date("d.m.y", strtotime($data->td)).$data->icon_str',
                                       'type' => 'html',
                                       'htmlOptions' => array('width' => '80px')
                                   ),
                                   array(
                                       'header' => 'Клиент',
                                       'name' => 'c_customer',
                                       'value' => '$data->c_customer."  ".$data->c_company',
                                       'htmlOptions' => array('style' => 'width:120px;')
                                   ),
                                   array(
                                       'header' => 'Контакты',
                                       'value' => '$data->c_mail."<BR>".$data->c_phone',
                                       'type' => 'html',
                                       'htmlOptions' => array('style' => 'width:120px;')
                                   ),
                                   array(
                                       'name' => 'is_banket_type',
                                       'filter' => CHtml::listData(DictBanketType::model()->actual()->findAll(), 'id', 'c_name'),
                                       'value' => '$data->BanketType->c_name',
                                   ),
                                   array(
                                       'header' => 'Дата события',
                                       'value' => '$data->dateEvent',
                                       'htmlOptions' => array('style' => 'white-space:nowrap'),
                                   ),
                                   array(
                                       'header' => 'Статус',
                                       'name' => 'is_demand_status',
                                       'value' => '$data->DemandStatus->c_name',
                                       'filter' => CHtml::listData(DictDemandStatus::model()->actual()->findAll(), 'id', 'c_name'),
                                   ),
                                   array(
                                       'header' => 'Комментарий БС',
                                       'value' => '$data->t_user_comment',
                                   ),
             array(
                'header' => 'Прибыль',
                'value' => '(!empty($data->profit))?$data->profit:"-"',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
        );
        Yii::app()->cache->set('archive_column_agent', $main_column_agent, 3600, $dependency);
    }
    $b = $this->widget('application.zii.widgets.grid.DefaultGridView', array(
                                                                            'id' => 'object-resto-grid',
                                                                            'dataProvider' => $model->search(),
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n",
                                                                            'columns' => $main_column_agent));

}
else {
    $main_column_manager = Yii::app()->cache->get('archive_column_manager');
    if ($main_column_manager === false) {
        $main_column_manager = array(
            array(
                'header' => '№ / Дата',
                'name' => 'id',
                'value' => '$data->id." / ".date("d.m.y", strtotime($data->td)).$data->icon_str',
                'type' => 'html',
                'htmlOptions' => array('width' => '80px')
            ),
            array(
                'header' => 'Клиент',
                'name' => 'c_customer',
                'value' => '$data->c_customer."  ".$data->c_company',
                'htmlOptions' => array('style' => 'width:120px;')
            ),
            array(
                'header' => 'Контакты',
                'value' => '$data->c_mail."<BR>".$data->c_phone',
                'type' => 'html',
                'htmlOptions' => array('style' => 'width:120px;')
            ),
            array(
                'name' => 'is_banket_type',
                'filter' => CHtml::listData(DictBanketType::model()->actual()->findAll(), 'id', 'c_name'),
                'value' => '$data->BanketType->c_name',
            ),
            array(
                'header' => 'Дата события',
                'value' => '$data->dateEvent',
                'htmlOptions' => array('style' => 'white-space:nowrap'),
            ),
            array(
                'header' => 'Менеджер',
                'name' => 'id_agent',
                'filter' => CHtml::listData(Users::model()->banket()->findAll(), 'id_user', 'c_name'),
                'value' => '$data->Agent->c_name',
            ),
            array(
                'header' => 'Статус',
                'name' => 'is_demand_status',
                'value' => '$data->DemandStatus->c_name',
                'filter' => CHtml::listData(DictDemandStatus::model()->actual()->findAll(), 'id', 'c_name'),
            ),
            array(
                'header' => 'Комментарий БС',
                'value' => '$data->t_user_comment',
            ),
             array(
                'header' => 'Прибыль',
                'value' => '(!empty($data->profit))?$data->profit:"-"',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
        );
        Yii::app()->cache->set('archive_column_manager', $main_column_manager, 3600, $dependency);
    }
    $b = $this->widget('application.zii.widgets.grid.DefaultGridView', array(
                                                                            'id' => 'object-resto-grid',
                                                                            'dataProvider' => $model->search($this->cnt_demands),
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n{pager}",
                                                                            'columns' => $main_column_manager));
}
