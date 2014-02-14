<?php
Yii::import('application.zii.widgets.grid.MyDateColumn');
$dependency = new CDbCacheDependency('SELECT MAX(updated_at) FROM cf_users');
$profit_column_agent = Yii::app()->cache->get('profit_column_agent');
if ($profit_column_agent === false) {
    $profit_column_agent = array(
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
            'header' => 'Прибыль (расч.)',
            'value' => '(!empty($data->profit))?$data->profit:"-"',
            'htmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'header' => 'Получено',
            'value' => '$data->f_profit',
            'htmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
                'header' => 'Дата',
                'name' => 'date_profit',
                'class' => 'MyDateColumn',
                'value' => '$data->date_profit',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align:center'),
         ),
    );
    Yii::app()->cache->set('profit_column_agent', $profit_column_agent, 3600, $dependency);
}
if (Yii::app()->user->CF_STATUS != 1) {
    $b = $this->widget('application.zii.widgets.grid.ProfitGridView', array(
                                                                            'id' => 'object-resto-grid3',
                                                                            'dataProvider' => $model->search($this->cnt_demands),
                                                                            'afterAjaxUpdate' => 'js: function(){$("#Demands_date_profit_from").datepicker([]); $("#Demands_date_profit_to").datepicker([]);}',
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n",
                                                                            'columns' => $profit_column_agent));

}
else {
    $profit_column_manager = Yii::app()->cache->get('profit_column_manager');
    if ($profit_column_manager === false) {
        $profit_column_manager = array(
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
            ), array(
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
                'header' => 'Прибыль (расч.)',
                'value' => '(!empty($data->profit))?$data->profit:"-"',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
            array(
                'header' => 'Получено',
                'value' => '$data->f_profit',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
            array(
                'header' => 'Дата',
                'name' => 'date_profit',
                'class' => 'MyDateColumn',
                'value' => '$data->date_profit',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align:center'),
            ),
        );
        Yii::app()->cache->set('profit_column_manager', $profit_column_manager, 3600, $dependency);
    }
    $b = $this->widget('application.zii.widgets.grid.ProfitGridView', array(
                                                                            'id' => 'object-resto-grid3',
                                                                            'dataProvider' => $model->search($this->cnt_demands),
                                                                            'afterAjaxUpdate' => 'js: function(){$("#Demands_date_profit_from").datepicker([]); $("#Demands_date_profit_to").datepicker([]);}',
                                                                            'formatter' => new Formatter,
                                                                            'filter' => $model,
                                                                            'pager' => $pager,
                                                                            'selectionChanged' => 'change_demand_grid',
                                                                            'template' => "{pager}\n{items}\n{summary}\n{pager}",
                                                                            'columns' => $profit_column_manager));
}
