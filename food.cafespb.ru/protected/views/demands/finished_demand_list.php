<?php
$dependency = new CDbCacheDependency('SELECT MAX(updated_at) FROM cf_users');
$sec_column_agent = Yii::app()->cache->get('finish_column_agent');
if ($sec_column_agent === false) {
    $sec_column_agent = array(
        array(
            'header' => '№ / Дата',
            'name' => 'id',
            'value' => '$data->id." / ".date("d.m.y", strtotime($data->td))',
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
            'header' => 'Комментарий БС',
            'value' => '$data->t_user_comment',
        ),
         array(
                'header' => 'Прибыль',
                'value' => '(!empty($data->profit))?$data->profit:"-"',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
    );
    Yii::app()->cache->set('finish_column_agent', $sec_column_agent, 3600, $dependency);
}
if (Yii::app()->user->CF_STATUS != 1) {
    $b = $this->widget('application.zii.widgets.grid.DefaultGridView', array(
                                                                            'id' => 'object-resto-grid2',
                                                                            'dataProvider' => $model->search(),
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n",
                                                                            'columns' => $sec_column_agent));

}
else {
    //Yii::app()->cache->delete('sec_column_manager');
    $sec_column_manager = Yii::app()->cache->get('finish_column_manager');
    if ($sec_column_manager === false) {
        $sec_column_manager = array(
            array(
                'header' => '№ / Дата',
                'name' => 'id',
                'value' => '$data->id." / ".date("d.m.y", strtotime($data->td))',
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
                'header' => 'Комментарий БС',
                'value' => '$data->t_user_comment',
            ),
             array(
                'header' => 'Прибыль',
                'value' => '(!empty($data->profit))?$data->profit:"-"',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
        );
        Yii::app()->cache->set('sec_column_manager', $finish_column_manager, 3600, $dependency);
    }
    $b = $this->widget('application.zii.widgets.grid.DefaultGridView', array(
                                                                            'id' => 'object-resto-grid2',
                                                                            'dataProvider' => $model->search($this->cnt_demands),
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n{pager}",
                                                                            'columns' => $sec_column_manager));
}

 
